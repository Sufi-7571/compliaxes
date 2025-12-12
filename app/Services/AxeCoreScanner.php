<?php

namespace App\Services;

use App\Models\Scan;
use App\Models\Issue;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class AxeCoreScanner
{
    protected $scan;
    protected $maxPages;
    protected $crawledUrls = [];

    public function scan(Scan $scan)
    {
        $this->scan = $scan;
        $website = $scan->website;
        $user = $website->user;

        // Get max pages from user's plan
        $this->maxPages = $user->subscriptionPlan
            ? $user->subscriptionPlan->max_pages_per_scan
            : 5;

        Log::info('Starting axe-core scan', ['website' => $website->url]);

        // Get URLs to scan
        $urls = $this->crawlWebsite($website->url);
        $this->scan->update(['total_pages' => count($urls)]);

        // Scan each page with axe-core
        foreach ($urls as $url) {
            $this->scanPageWithAxe($url);
        }

        // Calculate metrics
        $this->calculateScanMetrics();
    }

    protected function crawlWebsite($baseUrl)
    {
        // $this->crawledUrls[] = $baseUrl;

        // try {
        //     // Get HTML content
        //     $html = Browsershot::url($baseUrl)
        //         ->setNodeBinary('/usr/local/bin/node')
        //         ->setNpmBinary('/usr/local/bin/npm')
        //         ->timeout(120)
        //         ->bodyHtml();

        //     // Parse links (simple crawling)
        //     preg_match_all('/<a[^>]+href=["\'](.*?)["\']/', $html, $matches);

        //     if (!empty($matches[1])) {
        //         foreach ($matches[1] as $href) {
        //             if (count($this->crawledUrls) >= $this->maxPages) {
        //                 break;
        //             }

        //             $absoluteUrl = $this->makeAbsoluteUrl($href, $baseUrl);

        //             if (
        //                 $absoluteUrl &&
        //                 $this->isSameDomain($absoluteUrl, $baseUrl) &&
        //                 !in_array($absoluteUrl, $this->crawledUrls) &&
        //                 !$this->isAsset($absoluteUrl)
        //             ) {

        //                 $this->crawledUrls[] = $absoluteUrl;
        //             }
        //         }
        //     }
        // } catch (\Exception $e) {
        //     Log::error("Crawl error: " . $e->getMessage());
        // }

        // return array_slice($this->crawledUrls, 0, $this->maxPages);

        $this->crawledUrls = [$baseUrl];
    
        return $this->crawledUrls;
    }

    protected function scanPageWithAxe($url)
{
    try {
        Log::info('Scanning with axe-core', ['url' => $url]);
        
        // Create temp file for results
        $tempFile = storage_path('app/temp/axe-results-' . md5($url . time()) . '.json');
        
        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }
        
        // Path to the scanner script - UPDATED TO .cjs
        $scriptPath = base_path('resources/scripts/axe-scanner.cjs');
        
        if (!file_exists($scriptPath)) {
            Log::error('Scanner script not found', ['path' => $scriptPath]);
            return;
        }
        
        // Execute the Node.js script
        $command = "node " . escapeshellarg($scriptPath) . " " . escapeshellarg($url) . " " . escapeshellarg($tempFile) . " 2>&1";
        
        Log::info('Executing command', ['command' => $command]);
        
        $output = [];
        $returnCode = 0;
        exec($command, $output, $returnCode);
        
        Log::info('Command executed', [
            'return_code' => $returnCode,
            'output' => implode("\n", $output)
        ]);
        
        // Wait for results file (max 90 seconds)
        $maxWait = 90;
        $waited = 0;
        while (!file_exists($tempFile) && $waited < $maxWait) {
            sleep(1);
            $waited++;
        }
        
        if (file_exists($tempFile)) {
            $resultsJson = file_get_contents($tempFile);
            $results = json_decode($resultsJson, true);
            
            Log::info('Results loaded', [
                'file_size' => strlen($resultsJson),
                'has_violations' => isset($results['violations']),
                'violation_count' => isset($results['violations']) ? count($results['violations']) : 0
            ]);
            
            if (isset($results['error'])) {
                Log::error('Axe scan error in results', ['error' => $results['error'], 'url' => $url]);
            } elseif (isset($results['violations']) && is_array($results['violations'])) {
                Log::info('Processing violations', ['count' => count($results['violations']), 'url' => $url]);
                $this->processAxeResults($results['violations'], $url);
            } else {
                Log::warning('No violations found', ['url' => $url]);
            }
            
            // Clean up
            unlink($tempFile);
        } else {
            Log::error('Results file was not created', [
                'url' => $url,
                'temp_file' => $tempFile,
                'waited' => $waited
            ]);
        }
        
    } catch (\Exception $e) {
        Log::error('Axe scan exception', [
            'url' => $url,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}

    protected function processAxeResults($violations, $url)
    {
        foreach ($violations as $violation) {
            $severity = $this->mapImpactToSeverity($violation['impact'] ?? 'minor');
            $wcagLevel = $this->extractWcagLevel($violation['tags'] ?? []);

            // Get first node as example
            $node = $violation['nodes'][0] ?? null;
            $elementHtml = $node['html'] ?? '';
            $target = $node['target'][0] ?? '';

            // Create issue for each violation
            Issue::create([
                'scan_id' => $this->scan->id,
                'page_url' => $url,
                'issue_type' => $violation['id'],
                'severity' => $severity,
                'wcag_level' => $wcagLevel,
                'wcag_rule' => $this->extractWcagRule($violation['tags'] ?? []),
                'description' => $violation['description'] ?? $violation['help'],
                'element_selector' => is_array($target) ? implode(' ', $target) : $target,
                'element_html' => substr($elementHtml, 0, 500),
                'fix_suggestion' => $violation['helpUrl'] ?? 'Check axe-core documentation for fix',
                'code_before' => $elementHtml,
                'code_after' => 'Fix according to WCAG guidelines'
            ]);
        }
    }

    protected function mapImpactToSeverity($impact)
    {
        $map = [
            'critical' => 'critical',
            'serious' => 'critical',
            'moderate' => 'moderate',
            'minor' => 'minor'
        ];

        return $map[$impact] ?? 'minor';
    }

    protected function extractWcagLevel($tags)
    {
        if (in_array('wcag2a', $tags)) return 'A';
        if (in_array('wcag2aa', $tags)) return 'AA';
        if (in_array('wcag2aaa', $tags)) return 'AAA';
        if (in_array('wcag21a', $tags)) return 'A';
        if (in_array('wcag21aa', $tags)) return 'AA';
        if (in_array('wcag22aa', $tags)) return 'AA';

        return 'A';
    }

    protected function extractWcagRule($tags)
    {
        foreach ($tags as $tag) {
            if (preg_match('/wcag\d+([0-9.]+)/', $tag, $matches)) {
                return $matches[1];
            }
        }

        return 'N/A';
    }

    protected function makeAbsoluteUrl($href, $baseUrl)
    {
        $href = preg_replace('/#.*$/', '', $href);

        if (preg_match('/^(javascript|mailto|tel):/i', $href)) {
            return null;
        }

        if (parse_url($href, PHP_URL_SCHEME)) {
            return $href;
        }

        $base = parse_url($baseUrl);

        if (strpos($href, '//') === 0) {
            return $base['scheme'] . ':' . $href;
        }

        if (strpos($href, '/') === 0) {
            return $base['scheme'] . '://' . $base['host'] . $href;
        }

        $path = isset($base['path']) ? $base['path'] : '/';
        $path = preg_replace('/\/[^\/]*$/', '/', $path);

        return $base['scheme'] . '://' . $base['host'] . $path . $href;
    }

    protected function isSameDomain($url1, $url2)
    {
        $domain1 = parse_url($url1, PHP_URL_HOST);
        $domain2 = parse_url($url2, PHP_URL_HOST);

        $domain1 = preg_replace('/^www\./', '', $domain1);
        $domain2 = preg_replace('/^www\./', '', $domain2);

        return $domain1 === $domain2;
    }

    protected function isAsset($url)
    {
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'css', 'js', 'pdf', 'zip', 'mp4', 'mp3', 'woff', 'woff2', 'ttf'];
        $path = parse_url($url, PHP_URL_PATH);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($extension, $extensions);
    }

    protected function calculateScanMetrics()
    {
        $issues = $this->scan->issues;

        $criticalCount = $issues->where('severity', 'critical')->count();
        $moderateCount = $issues->where('severity', 'moderate')->count();
        $minorCount = $issues->where('severity', 'minor')->count();

        $totalCount = $issues->count();

        // Calculate realistic score
        $score = 100;

        if ($totalCount > 0) {
            $score -= ($criticalCount * 15);
            $score -= ($moderateCount * 8);
            $score -= ($minorCount * 3);
            $score = max(0, $score);
        }

        $this->scan->update([
            'total_issues' => $totalCount,
            'critical_issues' => $criticalCount,
            'moderate_issues' => $moderateCount,
            'minor_issues' => $minorCount,
            'accessibility_score' => $score
        ]);

        Log::info('Scan completed with axe-core', [
            'score' => $score,
            'total' => $totalCount,
            'critical' => $criticalCount
        ]);
    }
}
