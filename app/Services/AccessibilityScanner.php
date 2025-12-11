<?php

namespace App\Services;

use App\Models\Scan;
use App\Models\Issue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use DOMXPath;

class AccessibilityScanner
{
    protected $scan;
    protected $maxPages;
    protected $crawledUrls = [];
    protected $baseUrl;
    
    public function scan(Scan $scan)
    {
        $this->scan = $scan;
        $website = $scan->website;
        $user = $website->user;
        
        $this->baseUrl = $website->url;
        
        // Get max pages from user's plan
        $this->maxPages = $user->subscriptionPlan 
            ? $user->subscriptionPlan->max_pages_per_scan 
            : 5;
        
        Log::info('Starting scan', ['website' => $website->url, 'max_pages' => $this->maxPages]);
        
        // Start scanning
        $urls = $this->crawlWebsite($website->url);
        $this->scan->update(['total_pages' => count($urls)]);
        
        Log::info('Pages to scan', ['count' => count($urls), 'urls' => $urls]);
        
        // Scan each page
        foreach ($urls as $url) {
            $this->scanPage($url);
        }
        
        // Calculate totals and score
        $this->calculateScanMetrics();
    }
    
    protected function crawlWebsite($startUrl)
    {
        $this->crawledUrls[] = $startUrl;
        
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])
                ->get($startUrl);
            
            if ($response->successful()) {
                $html = $response->body();
                $dom = new DOMDocument();
                @$dom->loadHTML($html);
                $xpath = new DOMXPath($dom);
                
                // Find all links
                $links = $xpath->query('//a[@href]');
                
                foreach ($links as $link) {
                    if (count($this->crawledUrls) >= $this->maxPages) {
                        break;
                    }
                    
                    $href = $link->getAttribute('href');
                    $absoluteUrl = $this->makeAbsoluteUrl($href, $startUrl);
                    
                    if ($absoluteUrl && 
                        $this->isSameDomain($absoluteUrl, $startUrl) && 
                        !in_array($absoluteUrl, $this->crawledUrls) &&
                        !$this->isAsset($absoluteUrl)) {
                        
                        $this->crawledUrls[] = $absoluteUrl;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Crawl error: " . $e->getMessage());
        }
        
        return $this->crawledUrls;
    }
    
    protected function makeAbsoluteUrl($href, $baseUrl)
    {
        // Remove fragments and query strings for consistency
        $href = preg_replace('/#.*$/', '', $href);
        
        // Skip javascript:, mailto:, tel: links
        if (preg_match('/^(javascript|mailto|tel):/i', $href)) {
            return null;
        }
        
        // Already absolute with scheme
        if (parse_url($href, PHP_URL_SCHEME)) {
            return $href;
        }
        
        $base = parse_url($baseUrl);
        
        // Protocol-relative
        if (strpos($href, '//') === 0) {
            return $base['scheme'] . ':' . $href;
        }
        
        // Absolute path
        if (strpos($href, '/') === 0) {
            return $base['scheme'] . '://' . $base['host'] . $href;
        }
        
        // Relative path
        $path = isset($base['path']) ? $base['path'] : '/';
        $path = preg_replace('/\/[^\/]*$/', '/', $path);
        
        return $base['scheme'] . '://' . $base['host'] . $path . $href;
    }
    
    protected function isSameDomain($url1, $url2)
    {
        $domain1 = parse_url($url1, PHP_URL_HOST);
        $domain2 = parse_url($url2, PHP_URL_HOST);
        
        // Remove www. for comparison
        $domain1 = preg_replace('/^www\./', '', $domain1);
        $domain2 = preg_replace('/^www\./', '', $domain2);
        
        return $domain1 === $domain2;
    }
    
    protected function isAsset($url)
    {
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'css', 'js', 'pdf', 'zip', 'mp4', 'mp3'];
        $path = parse_url($url, PHP_URL_PATH);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        return in_array($extension, $extensions);
    }
    
    protected function scanPage($url)
    {
        try {
            Log::info('Scanning page', ['url' => $url]);
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])
                ->get($url);
            
            if (!$response->successful()) {
                Log::warning('Failed to fetch page', ['url' => $url, 'status' => $response->status()]);
                return;
            }
            
            $html = $response->body();
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);
            
            // Run all checks
            $this->checkMissingAltText($dom, $xpath, $url);
            $this->checkMissingFormLabels($dom, $xpath, $url);
            $this->checkMissingTitle($dom, $xpath, $url);
            $this->checkMissingLangAttribute($dom, $xpath, $url);
            $this->checkEmptyLinks($dom, $xpath, $url);
            $this->checkNonDescriptiveLinks($dom, $xpath, $url);
            $this->checkHeadingOrder($dom, $xpath, $url);
            $this->checkMissingButtonLabels($dom, $xpath, $url);
            $this->checkVideoAccessibility($dom, $xpath, $url);
            $this->checkKeyboardAccessibility($dom, $xpath, $url);
            $this->checkColorContrast($html, $url);
            $this->checkAriaRoles($dom, $xpath, $url);
            
            Log::info('Page scanned successfully', ['url' => $url]);
            
        } catch (\Exception $e) {
            Log::error("Error scanning page", ['url' => $url, 'error' => $e->getMessage()]);
        }
    }
    
    protected function checkMissingAltText($dom, $xpath, $url)
    {
        $images = $xpath->query('//img');
        
        foreach ($images as $img) {
            $alt = $img->getAttribute('alt');
            $src = $img->getAttribute('src');
            
            // Check if alt is missing or empty
            if (strlen(trim($alt)) === 0) {
                $html = $dom->saveHTML($img);
                
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_alt',
                    'severity' => 'critical',
                    'wcag_level' => 'A',
                    'wcag_rule' => '1.1.1',
                    'description' => 'Image is missing alternative text (alt attribute is empty or missing)',
                    'element_selector' => 'img[src="' . $src . '"]',
                    'element_html' => $html,
                    'fix_suggestion' => 'Add a descriptive alt attribute that conveys the purpose or content of the image. If the image is decorative, use alt="".',
                    'code_before' => $html,
                    'code_after' => '<img src="' . $src . '" alt="Description of the image content">'
                ]);
            }
        }
    }
    
    protected function checkMissingFormLabels($dom, $xpath, $url)
    {
        $inputs = $xpath->query('//input[@type!="hidden" and @type!="submit" and @type!="button" and @type!="image"]');
        
        foreach ($inputs as $input) {
            $id = $input->getAttribute('id');
            $ariaLabel = $input->getAttribute('aria-label');
            $ariaLabelledby = $input->getAttribute('aria-labelledby');
            $type = $input->getAttribute('type');
            
            $hasLabel = false;
            
            // Check for associated label
            if ($id) {
                $labels = $xpath->query("//label[@for='{$id}']");
                if ($labels->length > 0) {
                    $hasLabel = true;
                }
            }
            
            // Check for wrapping label
            $parent = $input->parentNode;
            while ($parent) {
                if ($parent->nodeName === 'label') {
                    $hasLabel = true;
                    break;
                }
                $parent = $parent->parentNode;
            }
            
            if (!$hasLabel && !$ariaLabel && !$ariaLabelledby) {
                $html = $dom->saveHTML($input);
                
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_form_label',
                    'severity' => 'critical',
                    'wcag_level' => 'A',
                    'wcag_rule' => '3.3.2',
                    'description' => 'Form input is missing an accessible label',
                    'element_html' => $html,
                    'fix_suggestion' => 'Add a <label> element associated with this input using the for attribute, or add an aria-label attribute.',
                    'code_before' => $html,
                    'code_after' => '<label for="input-id">Input Label:</label>' . "\n" . '<input id="input-id" type="' . $type . '" name="...">'
                ]);
            }
        }
    }
    
    protected function checkMissingTitle($dom, $xpath, $url)
    {
        $titles = $xpath->query('//title');
        
        if ($titles->length === 0 || trim($titles->item(0)->textContent) === '') {
            Issue::create([
                'scan_id' => $this->scan->id,
                'page_url' => $url,
                'issue_type' => 'missing_title',
                'severity' => 'critical',
                'wcag_level' => 'A',
                'wcag_rule' => '2.4.2',
                'description' => 'Page is missing a title element or the title is empty',
                'fix_suggestion' => 'Add a descriptive <title> element in the <head> section that describes the page content.',
                'code_before' => '<head></head>',
                'code_after' => '<head><title>Descriptive Page Title - Site Name</title></head>'
            ]);
        }
    }
    
    protected function checkMissingLangAttribute($dom, $xpath, $url)
    {
        $htmlElements = $xpath->query('//html');
        
        if ($htmlElements->length > 0) {
            $html = $htmlElements->item(0);
            $lang = $html->getAttribute('lang');
            
            if (strlen(trim($lang)) === 0) {
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_lang',
                    'severity' => 'moderate',
                    'wcag_level' => 'A',
                    'wcag_rule' => '3.1.1',
                    'description' => 'HTML element is missing the lang attribute',
                    'fix_suggestion' => 'Add a lang attribute to the <html> element to specify the primary language of the page.',
                    'code_before' => '<html>',
                    'code_after' => '<html lang="en">'
                ]);
            }
        }
    }
    
    protected function checkEmptyLinks($dom, $xpath, $url)
    {
        $links = $xpath->query('//a[@href]');
        
        foreach ($links as $link) {
            $text = trim($link->textContent);
            $ariaLabel = $link->getAttribute('aria-label');
            $title = $link->getAttribute('title');
            
            // Check if link has images
            $images = $xpath->query('.//img', $link);
            $hasImage = $images->length > 0;
            
            if (strlen($text) === 0 && !$ariaLabel && !$title && !$hasImage) {
                $html = $dom->saveHTML($link);
                $href = $link->getAttribute('href');
                
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'empty_link',
                    'severity' => 'critical',
                    'wcag_level' => 'A',
                    'wcag_rule' => '2.4.4',
                    'description' => 'Link has no accessible text or label',
                    'element_html' => $html,
                    'fix_suggestion' => 'Add descriptive text inside the link, or use aria-label to provide an accessible name.',
                    'code_before' => $html,
                    'code_after' => '<a href="' . $href . '">Descriptive link text</a>'
                ]);
            }
        }
    }
    
    protected function checkNonDescriptiveLinks($dom, $xpath, $url)
    {
        $nonDescriptiveTexts = ['click here', 'read more', 'more', 'link', 'here', 'click', 'this'];
        
        $links = $xpath->query('//a[@href]');
        
        foreach ($links as $link) {
            $text = strtolower(trim($link->textContent));
            
            if (in_array($text, $nonDescriptiveTexts)) {
                $html = $dom->saveHTML($link);
                
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'non_descriptive_link',
                    'severity' => 'minor',
                    'wcag_level' => 'A',
                    'wcag_rule' => '2.4.4',
                    'description' => "Link text '{$text}' is not descriptive enough",
                    'element_html' => $html,
                    'fix_suggestion' => 'Use descriptive link text that makes sense out of context. Avoid generic phrases like "click here".',
                    'code_before' => $html,
                    'code_after' => '<a href="...">Learn more about accessibility best practices</a>'
                ]);
            }
        }
    }
    
    protected function checkHeadingOrder($dom, $xpath, $url)
    {
        $headings = [];
        for ($i = 1; $i <= 6; $i++) {
            $elements = $xpath->query("//h{$i}");
            foreach ($elements as $element) {
                $headings[] = [
                    'level' => $i,
                    'text' => trim($element->textContent),
                    'html' => $dom->saveHTML($element)
                ];
            }
        }
        
        $previousLevel = 0;
        foreach ($headings as $heading) {
            if ($previousLevel > 0 && $heading['level'] > $previousLevel + 1) {
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'heading_skip',
                    'severity' => 'minor',
                    'wcag_level' => 'A',
                    'wcag_rule' => '1.3.1',
                    'description' => "Heading hierarchy skips from H{$previousLevel} to H{$heading['level']}",
                    'element_html' => $heading['html'],
                    'fix_suggestion' => 'Maintain proper heading hierarchy. Don\'t skip heading levels (e.g., H2 should not jump to H4).',
                    'code_before' => $heading['html'],
                    'code_after' => str_replace("<h{$heading['level']}", "<h" . ($previousLevel + 1), $heading['html'])
                ]);
            }
            $previousLevel = $heading['level'];
        }
    }
    
    protected function checkMissingButtonLabels($dom, $xpath, $url)
    {
        $buttons = $xpath->query('//button');
        
        foreach ($buttons as $button) {
            $text = trim($button->textContent);
            $ariaLabel = $button->getAttribute('aria-label');
            $ariaLabelledby = $button->getAttribute('aria-labelledby');
            
            if (strlen($text) === 0 && !$ariaLabel && !$ariaLabelledby) {
                $html = $dom->saveHTML($button);
                
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_button_label',
                    'severity' => 'critical',
                    'wcag_level' => 'A',
                    'wcag_rule' => '4.1.2',
                    'description' => 'Button has no accessible text or label',
                    'element_html' => $html,
                    'fix_suggestion' => 'Add text content to the button or use aria-label to provide an accessible name.',
                    'code_before' => $html,
                    'code_after' => '<button aria-label="Close dialog">×</button>'
                ]);
            }
        }
    }
    
    protected function checkVideoAccessibility($dom, $xpath, $url)
    {
        $videos = $xpath->query('//video');
        
        foreach ($videos as $video) {
            $tracks = $xpath->query('.//track', $video);
            
            if ($tracks->length === 0) {
                $html = $dom->saveHTML($video);
                
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_captions',
                    'severity' => 'moderate',
                    'wcag_level' => 'A',
                    'wcag_rule' => '1.2.2',
                    'description' => 'Video element is missing captions or subtitles',
                    'element_html' => substr($html, 0, 200) . '...',
                    'fix_suggestion' => 'Add a <track> element with captions for the video content.',
                    'code_before' => '<video src="video.mp4"></video>',
                    'code_after' => '<video src="video.mp4"><track kind="captions" src="captions.vtt" srclang="en" label="English"></video>'
                ]);
            }
        }
    }
    
    protected function checkKeyboardAccessibility($dom, $xpath, $url)
    {
        $clickableElements = $xpath->query('//*[@onclick and not(self::button) and not(self::a)]');
        
        foreach ($clickableElements as $element) {
            $tabindex = $element->getAttribute('tabindex');
            $role = $element->getAttribute('role');
            
            if (!$tabindex && $role !== 'button' && $role !== 'link') {
                $html = $dom->saveHTML($element);
                
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'keyboard_inaccessible',
                    'severity' => 'critical',
                    'wcag_level' => 'A',
                    'wcag_rule' => '2.1.1',
                    'description' => 'Element with click handler is not keyboard accessible',
                    'element_html' => substr($html, 0, 200),
                    'fix_suggestion' => 'Add tabindex="0" and keyboard event handlers, or use a <button> element instead.',
                    'code_before' => '<div onclick="doSomething()">',
                    'code_after' => '<button onclick="doSomething()">Action</button>'
                ]);
            }
        }
    }
    
    protected function checkColorContrast($html, $url)
    {
        // Check for inline styles with potential contrast issues
        if (preg_match_all('/style="[^"]*color:\s*#?([0-9a-fA-F]{3,6})[^"]*"/i', $html, $matches)) {
            foreach ($matches[1] as $color) {
                if ($this->isPotentiallyLowContrast($color)) {
                    Issue::create([
                        'scan_id' => $this->scan->id,
                        'page_url' => $url,
                        'issue_type' => 'potential_contrast',
                        'severity' => 'moderate',
                        'wcag_level' => 'AA',
                        'wcag_rule' => '1.4.3',
                        'description' => 'Potential color contrast issue detected with color #' . $color,
                        'fix_suggestion' => 'Ensure text has a contrast ratio of at least 4.5:1 for normal text and 3:1 for large text against its background.',
                        'code_before' => 'color: #' . $color . ';',
                        'code_after' => 'color: #333333; /* Ensure sufficient contrast */'
                    ]);
                }
            }
        }
    }
    
    protected function isPotentiallyLowContrast($hex)
    {
        // Normalize hex
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        
        // Convert to RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        // Calculate relative luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        
        // Flag very light or very dark colors as potential issues
        return $luminance > 0.85 || $luminance < 0.15;
    }
    
    protected function checkAriaRoles($dom, $xpath, $url)
    {
        $invalidRoles = ['banner', 'navigation', 'main', 'contentinfo'];
        $elementsWithRole = $xpath->query('//*[@role]');
        
        foreach ($elementsWithRole as $element) {
            $role = $element->getAttribute('role');
            
            // Check for duplicate landmark roles
            foreach ($invalidRoles as $landmarkRole) {
                if ($role === $landmarkRole) {
                    $duplicates = $xpath->query("//*[@role='{$landmarkRole}']");
                    if ($duplicates->length > 1) {
                        $html = $dom->saveHTML($element);
                        
                        Issue::create([
                            'scan_id' => $this->scan->id,
                            'page_url' => $url,
                            'issue_type' => 'duplicate_landmark',
                            'severity' => 'minor',
                            'wcag_level' => 'A',
                            'wcag_rule' => '4.1.2',
                            'description' => "Multiple elements with role='{$landmarkRole}' found. Each should have a unique label.",
                            'element_html' => substr($html, 0, 200),
                            'fix_suggestion' => 'Add aria-label or aria-labelledby to distinguish multiple landmarks of the same type.',
                            'code_before' => '<div role="navigation">',
                            'code_after' => '<div role="navigation" aria-label="Main navigation">'
                        ]);
                        break;
                    }
                }
            }
        }
    }
    
    protected function calculateScanMetrics()
    {
        $issues = $this->scan->issues;
        
        $criticalCount = $issues->where('severity', 'critical')->count();
        $moderateCount = $issues->where('severity', 'moderate')->count();
        $minorCount = $issues->where('severity', 'minor')->count();
        
        $totalCount = $issues->count();
        
        Log::info('Scan metrics', [
            'total' => $totalCount,
            'critical' => $criticalCount,
            'moderate' => $moderateCount,
            'minor' => $minorCount
        ]);
        
        // More realistic scoring
        $score = 100;
        
        if ($totalCount > 0) {
            // Deduct points based on severity
            $score -= ($criticalCount * 15);  // Critical issues: -15 points each
            $score -= ($moderateCount * 8);   // Moderate issues: -8 points each
            $score -= ($minorCount * 3);      // Minor issues: -3 points each
            
            // Ensure score doesn't go below 0
            $score = max(0, $score);
        }
        
        $this->scan->update([
            'total_issues' => $totalCount,
            'critical_issues' => $criticalCount,
            'moderate_issues' => $moderateCount,
            'minor_issues' => $minorCount,
            'accessibility_score' => $score
        ]);
        
        Log::info('Scan completed', ['score' => $score, 'total_issues' => $totalCount]);
    }
}