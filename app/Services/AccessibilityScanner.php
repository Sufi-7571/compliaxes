<?php

namespace App\Services;

use App\Models\Scan;
use App\Models\Issue;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use DOMXPath;

class AccessibilityScanner
{
    protected $scan;
    protected $maxPages;

    public function scan(Scan $scan)
    {
        $this->scan = $scan;
        $website = $scan->website;
        $user = $website->user;

        // Get max pages from user's plan
        $this->maxPages = $user->subscriptionPlan
            ? $user->subscriptionPlan->max_pages_per_scan
            : 5;

        // Start scanning
        $urls = $this->crawlWebsite($website->url);
        $this->scan->update(['total_pages' => count($urls)]);

        // Scan each page
        foreach ($urls as $url) {
            $this->scanPage($url);
        }

        // Calculate totals and score
        $this->calculateScanMetrics();
    }

    protected function crawlWebsite($baseUrl)
    {
        $urls = [$baseUrl];

        // For MVP, just scan the homepage
        // Later can add internal link crawling

        return array_slice($urls, 0, $this->maxPages);
    }

    protected function scanPage($url)
    {
        try {
            $response = Http::timeout(30)->get($url);

            if (!$response->successful()) {
                return;
            }

            $html = $response->body();

            // Run all checks
            $this->checkMissingAltText($html, $url);
            $this->checkMissingFormLabels($html, $url);
            $this->checkMissingTitle($html, $url);
            $this->checkMissingLangAttribute($html, $url);
            $this->checkEmptyLinks($html, $url);
            $this->checkHeadingOrder($html, $url);
        } catch (\Exception $e) {
            \Log::error("Error scanning page {$url}: " . $e->getMessage());
        }
    }

    protected function checkMissingAltText($html, $url)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $images = $xpath->query('//img[not(@alt) or @alt=""]');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');

            Issue::create([
                'scan_id' => $this->scan->id,
                'page_url' => $url,
                'issue_type' => 'missing_alt',
                'severity' => 'critical',
                'wcag_level' => 'A',
                'wcag_rule' => '1.1.1',
                'description' => 'Image missing alt text',
                'element_selector' => 'img[src="' . $src . '"]',
                'element_html' => $dom->saveHTML($img),
                'fix_suggestion' => 'Add descriptive alt text to the image',
                'code_before' => $dom->saveHTML($img),
                'code_after' => '<img src="' . $src . '" alt="Descriptive text here">'
            ]);
        }
    }

    protected function checkMissingFormLabels($html, $url)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $inputs = $xpath->query('//input[@type!="hidden" and @type!="submit" and not(@aria-label) and not(@id)]');

        foreach ($inputs as $input) {
            Issue::create([
                'scan_id' => $this->scan->id,
                'page_url' => $url,
                'issue_type' => 'missing_form_label',
                'severity' => 'critical',
                'wcag_level' => 'A',
                'wcag_rule' => '3.3.2',
                'description' => 'Form input missing label',
                'element_html' => $dom->saveHTML($input),
                'fix_suggestion' => 'Add a label element or aria-label attribute',
                'code_before' => $dom->saveHTML($input),
                'code_after' => '<label for="input_id">Label text</label>' . $dom->saveHTML($input)
            ]);
        }
    }

    protected function checkMissingTitle($html, $url)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $title = $xpath->query('//title');

        if ($title->length === 0 || trim($title->item(0)->textContent) === '') {
            Issue::create([
                'scan_id' => $this->scan->id,
                'page_url' => $url,
                'issue_type' => 'missing_title',
                'severity' => 'critical',
                'wcag_level' => 'A',
                'wcag_rule' => '2.4.2',
                'description' => 'Page missing title tag',
                'fix_suggestion' => 'Add a descriptive title tag in the head section',
                'code_before' => '<head>...</head>',
                'code_after' => '<head><title>Page Title</title></head>'
            ]);
        }
    }

    protected function checkMissingLangAttribute($html, $url)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $htmlTag = $xpath->query('//html[not(@lang)]');

        if ($htmlTag->length > 0) {
            Issue::create([
                'scan_id' => $this->scan->id,
                'page_url' => $url,
                'issue_type' => 'missing_lang',
                'severity' => 'moderate',
                'wcag_level' => 'A',
                'wcag_rule' => '3.1.1',
                'description' => 'HTML tag missing lang attribute',
                'fix_suggestion' => 'Add lang attribute to html tag',
                'code_before' => '<html>',
                'code_after' => '<html lang="en">'
            ]);
        }
    }

    protected function checkEmptyLinks($html, $url)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $emptyLinks = $xpath->query('//a[not(normalize-space()) and not(.//img)]');

        foreach ($emptyLinks as $link) {
            Issue::create([
                'scan_id' => $this->scan->id,
                'page_url' => $url,
                'issue_type' => 'empty_link',
                'severity' => 'moderate',
                'wcag_level' => 'A',
                'wcag_rule' => '2.4.4',
                'description' => 'Link has no text content',
                'element_html' => $dom->saveHTML($link),
                'fix_suggestion' => 'Add descriptive text to the link',
                'code_before' => $dom->saveHTML($link),
                'code_after' => '<a href="#">Descriptive link text</a>'
            ]);
        }
    }

    protected function checkHeadingOrder($html, $url)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $headings = $xpath->query('//h1 | //h2 | //h3 | //h4 | //h5 | //h6');

        $previousLevel = 0;
        foreach ($headings as $heading) {
            $currentLevel = (int) substr($heading->nodeName, 1);

            if ($previousLevel > 0 && $currentLevel > $previousLevel + 1) {
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'heading_skip',
                    'severity' => 'minor',
                    'wcag_level' => 'A',
                    'wcag_rule' => '1.3.1',
                    'description' => "Heading skipped from H{$previousLevel} to H{$currentLevel}",
                    'element_html' => $dom->saveHTML($heading),
                    'fix_suggestion' => 'Use proper heading hierarchy without skipping levels'
                ]);
            }

            $previousLevel = $currentLevel;
        }
    }

    protected function calculateScanMetrics()
    {
        $issues = $this->scan->issues;

        $criticalCount = $issues->where('severity', 'critical')->count();
        $moderateCount = $issues->where('severity', 'moderate')->count();
        $minorCount = $issues->where('severity', 'minor')->count();

        $totalCount = $issues->count();

        // Calculate score (100 - weighted issues)
        $score = 100 - (
            ($criticalCount * 10) +
            ($moderateCount * 5) +
            ($minorCount * 2)
        );

        $score = max(0, min(100, $score));

        $this->scan->update([
            'total_issues' => $totalCount,
            'critical_issues' => $criticalCount,
            'moderate_issues' => $moderateCount,
            'minor_issues' => $minorCount,
            'accessibility_score' => $score
        ]);
    }
}
