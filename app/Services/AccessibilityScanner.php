<?php

namespace App\Services;

use App\Models\Scan;
use App\Models\Issue;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class AccessibilityScanner
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
        $this->crawledUrls[] = $baseUrl;

        try {
            $response = Http::timeout(30)->get($baseUrl);

            if ($response->successful()) {
                $html = $response->body();
                $crawler = new Crawler($html, $baseUrl);

                // Find internal links
                $links = $crawler->filter('a')->each(function (Crawler $node) use ($baseUrl) {
                    $href = $node->attr('href');
                    if (!$href) return null;

                    // Convert relative URLs to absolute
                    $absoluteUrl = $this->makeAbsoluteUrl($href, $baseUrl);

                    // Only include URLs from same domain
                    if ($this->isSameDomain($absoluteUrl, $baseUrl)) {
                        return $absoluteUrl;
                    }
                    return null;
                });

                $links = array_filter(array_unique($links));

                // Add new URLs up to max pages limit
                foreach ($links as $link) {
                    if (count($this->crawledUrls) >= $this->maxPages) {
                        break;
                    }
                    if (!in_array($link, $this->crawledUrls)) {
                        $this->crawledUrls[] = $link;
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Crawl error: " . $e->getMessage());
        }

        return array_slice($this->crawledUrls, 0, $this->maxPages);
    }

    protected function makeAbsoluteUrl($href, $baseUrl)
    {
        // Already absolute
        if (parse_url($href, PHP_URL_SCHEME) !== null) {
            return $href;
        }

        $base = parse_url($baseUrl);

        // Protocol-relative URL
        if (strpos($href, '//') === 0) {
            return $base['scheme'] . ':' . $href;
        }

        // Root-relative URL
        if (strpos($href, '/') === 0) {
            return $base['scheme'] . '://' . $base['host'] . $href;
        }

        // Relative URL
        $path = isset($base['path']) ? dirname($base['path']) : '';
        return $base['scheme'] . '://' . $base['host'] . $path . '/' . $href;
    }

    protected function isSameDomain($url1, $url2)
    {
        $domain1 = parse_url($url1, PHP_URL_HOST);
        $domain2 = parse_url($url2, PHP_URL_HOST);
        return $domain1 === $domain2;
    }

    protected function scanPage($url)
    {
        try {
            $response = Http::timeout(30)->get($url);

            if (!$response->successful()) {
                return;
            }

            $html = $response->body();
            $crawler = new Crawler($html, $url);

            // Run all accessibility checks
            $this->checkMissingAltText($crawler, $url);
            $this->checkColorContrast($crawler, $url);
            $this->checkMissingFormLabels($crawler, $url);
            $this->checkMissingTitle($crawler, $url);
            $this->checkMissingLangAttribute($crawler, $url);
            $this->checkEmptyLinks($crawler, $url);
            $this->checkNonDescriptiveLinks($crawler, $url);
            $this->checkHeadingOrder($crawler, $url);
            $this->checkMissingAriaLabels($crawler, $url);
            $this->checkTouchTargetSize($crawler, $url);
            $this->checkKeyboardAccessibility($crawler, $url);
            $this->checkVideoAccessibility($crawler, $url);
            $this->checkFormErrors($crawler, $url);
        } catch (\Exception $e) {
            \Log::error("Error scanning page {$url}: " . $e->getMessage());
        }
    }

    protected function checkMissingAltText($crawler, $url)
    {
        $images = $crawler->filter('img')->each(function (Crawler $node) use ($url) {
            $alt = $node->attr('alt');
            $src = $node->attr('src');

            if ($alt === null || trim($alt) === '') {
                $html = $node->outerHtml();

                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_alt',
                    'severity' => 'critical',
                    'wcag_level' => 'A',
                    'wcag_rule' => '1.1.1',
                    'description' => 'Image missing alternative text (alt attribute)',
                    'element_selector' => 'img[src="' . $src . '"]',
                    'element_html' => $html,
                    'fix_suggestion' => 'Add a descriptive alt attribute that describes the image content or purpose',
                    'code_before' => $html,
                    'code_after' => str_replace('<img', '<img alt="Descriptive text about the image"', $html)
                ]);
            }
        });
    }

    protected function checkColorContrast($crawler, $url)
    {
        // Check for potential low contrast (simplified check)
        $styles = $crawler->filter('style')->each(function (Crawler $node) use ($url) {
            $css = $node->text();

            // Look for light colors on light backgrounds
            if (preg_match_all('/color:\s*#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})/i', $css, $matches)) {
                foreach ($matches[1] as $color) {
                    if ($this->isLightColor($color)) {
                        Issue::create([
                            'scan_id' => $this->scan->id,
                            'page_url' => $url,
                            'issue_type' => 'low_contrast',
                            'severity' => 'moderate',
                            'wcag_level' => 'AA',
                            'wcag_rule' => '1.4.3',
                            'description' => 'Potential low color contrast detected',
                            'fix_suggestion' => 'Ensure text has a contrast ratio of at least 4.5:1 for normal text and 3:1 for large text',
                            'code_before' => "color: #{$color};",
                            'code_after' => "color: #333333; /* Darker color for better contrast */"
                        ]);
                    }
                }
            }
        });
    }

    protected function isLightColor($hex)
    {
        // Convert hex to RGB
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Calculate relative luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $luminance > 0.7; // Light color threshold
    }

    protected function checkMissingFormLabels($crawler, $url)
    {
        $inputs = $crawler->filter('input:not([type="hidden"]):not([type="submit"]):not([type="button"])')->each(function (Crawler $node) use ($url) {
            $id = $node->attr('id');
            $ariaLabel = $node->attr('aria-label');
            $ariaLabelledBy = $node->attr('aria-labelledby');
            $placeholder = $node->attr('placeholder');

            // Check if input has a label
            $hasLabel = false;

            if ($id) {
                try {
                    $label = $node->ancestors()->first()->filter("label[for='{$id}']");
                    if ($label->count() > 0) {
                        $hasLabel = true;
                    }
                } catch (\Exception $e) {
                    // Continue checking
                }
            }

            if (!$hasLabel && !$ariaLabel && !$ariaLabelledBy) {
                $html = $node->outerHtml();

                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_form_label',
                    'severity' => 'critical',
                    'wcag_level' => 'A',
                    'wcag_rule' => '3.3.2',
                    'description' => 'Form input missing associated label',
                    'element_html' => $html,
                    'fix_suggestion' => 'Add a label element with a for attribute, or add aria-label attribute',
                    'code_before' => $html,
                    'code_after' => '<label for="input-id">Input Label</label>' . "\n" . str_replace('<input', '<input id="input-id"', $html)
                ]);
            }
        });
    }

    protected function checkMissingTitle($crawler, $url)
    {
        $title = $crawler->filter('title');

        if ($title->count() === 0 || trim($title->text()) === '') {
            Issue::create([
                'scan_id' => $this->scan->id,
                'page_url' => $url,
                'issue_type' => 'missing_title',
                'severity' => 'critical',
                'wcag_level' => 'A',
                'wcag_rule' => '2.4.2',
                'description' => 'Page missing title element or title is empty',
                'fix_suggestion' => 'Add a descriptive title tag in the head section',
                'code_before' => '<head>...</head>',
                'code_after' => '<head><title>Descriptive Page Title</title></head>'
            ]);
        }
    }

    protected function checkMissingLangAttribute($crawler, $url)
    {
        $html = $crawler->filter('html');

        if ($html->count() > 0) {
            $lang = $html->attr('lang');

            if (!$lang || trim($lang) === '') {
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_lang',
                    'severity' => 'moderate',
                    'wcag_level' => 'A',
                    'wcag_rule' => '3.1.1',
                    'description' => 'HTML element missing lang attribute',
                    'fix_suggestion' => 'Add lang attribute to the html tag to specify page language',
                    'code_before' => '<html>',
                    'code_after' => '<html lang="en">'
                ]);
            }
        }
    }

    protected function checkEmptyLinks($crawler, $url)
    {
        $emptyLinks = $crawler->filter('a')->each(function (Crawler $node) use ($url) {
            $text = trim($node->text());
            $ariaLabel = $node->attr('aria-label');
            $title = $node->attr('title');
            $hasImage = $node->filter('img')->count() > 0;

            if (empty($text) && !$ariaLabel && !$title && !$hasImage) {
                $html = $node->outerHtml();

                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'empty_link',
                    'severity' => 'moderate',
                    'wcag_level' => 'A',
                    'wcag_rule' => '2.4.4',
                    'description' => 'Link has no accessible text',
                    'element_html' => $html,
                    'fix_suggestion' => 'Add descriptive text inside the link or use aria-label attribute',
                    'code_before' => $html,
                    'code_after' => '<a href="...">Descriptive link text</a>'
                ]);
            }
        });
    }

    protected function checkNonDescriptiveLinks($crawler, $url)
    {
        $nonDescriptive = ['click here', 'read more', 'more', 'link', 'here'];

        $crawler->filter('a')->each(function (Crawler $node) use ($url, $nonDescriptive) {
            $text = strtolower(trim($node->text()));

            if (in_array($text, $nonDescriptive)) {
                $html = $node->outerHtml();

                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'non_descriptive_link',
                    'severity' => 'minor',
                    'wcag_level' => 'A',
                    'wcag_rule' => '2.4.4',
                    'description' => "Link text '{$text}' is not descriptive",
                    'element_html' => $html,
                    'fix_suggestion' => 'Use descriptive link text that makes sense out of context',
                    'code_before' => $html,
                    'code_after' => '<a href="...">Learn more about accessibility guidelines</a>'
                ]);
            }
        });
    }

    protected function checkHeadingOrder($crawler, $url)
    {
        $headings = $crawler->filter('h1, h2, h3, h4, h5, h6')->each(function (Crawler $node) {
            return [
                'level' => (int) substr($node->nodeName(), 1),
                'html' => $node->outerHtml(),
                'text' => trim($node->text())
            ];
        });

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
                    'description' => "Heading level skipped from H{$previousLevel} to H{$heading['level']}",
                    'element_html' => $heading['html'],
                    'fix_suggestion' => 'Use proper heading hierarchy without skipping levels (H1 → H2 → H3)',
                    'code_before' => $heading['html'],
                    'code_after' => str_replace("<h{$heading['level']}", "<h" . ($previousLevel + 1), $heading['html'])
                ]);
            }
            $previousLevel = $heading['level'];
        }
    }

    protected function checkMissingAriaLabels($crawler, $url)
    {
        $buttons = $crawler->filter('button')->each(function (Crawler $node) use ($url) {
            $text = trim($node->text());
            $ariaLabel = $node->attr('aria-label');
            $ariaLabelledBy = $node->attr('aria-labelledby');
            $hasImage = $node->filter('img')->count() > 0;

            if (empty($text) && !$ariaLabel && !$ariaLabelledBy && !$hasImage) {
                $html = $node->outerHtml();

                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_button_label',
                    'severity' => 'critical',
                    'wcag_level' => 'A',
                    'wcag_rule' => '4.1.2',
                    'description' => 'Button missing accessible name',
                    'element_html' => $html,
                    'fix_suggestion' => 'Add text content to the button or use aria-label attribute',
                    'code_before' => $html,
                    'code_after' => '<button aria-label="Descriptive button purpose">Icon</button>'
                ]);
            }
        });
    }

    protected function checkTouchTargetSize($crawler, $url)
    {
        // This is a simplified check - in real implementation, you'd need to check computed styles
        $crawler->filter('a, button')->each(function (Crawler $node) use ($url) {
            $style = $node->attr('style');

            if ($style && (strpos($style, 'font-size') !== false || strpos($style, 'padding') !== false)) {
                // Check for very small sizes
                if (preg_match('/font-size:\s*([0-9]+)px/', $style, $matches)) {
                    $size = (int) $matches[1];
                    if ($size < 10) {
                        $html = $node->outerHtml();

                        Issue::create([
                            'scan_id' => $this->scan->id,
                            'page_url' => $url,
                            'issue_type' => 'small_touch_target',
                            'severity' => 'minor',
                            'wcag_level' => 'AAA',
                            'wcag_rule' => '2.5.5',
                            'description' => 'Touch target may be too small (recommended minimum 44x44 pixels)',
                            'element_html' => $html,
                            'fix_suggestion' => 'Increase the size of clickable elements to at least 44x44 pixels',
                            'code_before' => $style,
                            'code_after' => 'min-width: 44px; min-height: 44px; padding: 12px;'
                        ]);
                    }
                }
            }
        });
    }

    protected function checkKeyboardAccessibility($crawler, $url)
    {
        $crawler->filter('[onclick]')->each(function (Crawler $node) use ($url) {
            $tabindex = $node->attr('tabindex');
            $role = $node->attr('role');

            // Elements with onclick should be keyboard accessible
            if ($node->nodeName() !== 'button' && $node->nodeName() !== 'a' && $tabindex === null) {
                $html = $node->outerHtml();

                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'keyboard_trap',
                    'severity' => 'critical',
                    'wcag_level' => 'A',
                    'wcag_rule' => '2.1.1',
                    'description' => 'Element with click handler may not be keyboard accessible',
                    'element_html' => substr($html, 0, 200),
                    'fix_suggestion' => 'Add tabindex="0" and keyboard event handlers, or use a button element',
                    'code_before' => '<div onclick="...">',
                    'code_after' => '<button onclick="...">Button text</button>'
                ]);
            }
        });
    }

    protected function checkVideoAccessibility($crawler, $url)
    {
        $crawler->filter('video')->each(function (Crawler $node) use ($url) {
            $hasTrack = $node->filter('track')->count() > 0;

            if (!$hasTrack) {
                $html = $node->outerHtml();

                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'missing_captions',
                    'severity' => 'moderate',
                    'wcag_level' => 'A',
                    'wcag_rule' => '1.2.2',
                    'description' => 'Video element missing captions track',
                    'element_html' => substr($html, 0, 200),
                    'fix_suggestion' => 'Add captions using the track element with kind="captions"',
                    'code_before' => '<video src="...">',
                    'code_after' => '<video src="..."><track kind="captions" src="captions.vtt" srclang="en" label="English"></video>'
                ]);
            }
        });
    }

    protected function checkFormErrors($crawler, $url)
    {
        $crawler->filter('form')->each(function (Crawler $node) use ($url) {
            $hasAriaDescribedBy = false;

            $node->filter('input, textarea, select')->each(function (Crawler $input) use (&$hasAriaDescribedBy) {
                if ($input->attr('aria-describedby') || $input->attr('aria-errormessage')) {
                    $hasAriaDescribedBy = true;
                }
            });

            if (!$hasAriaDescribedBy) {
                Issue::create([
                    'scan_id' => $this->scan->id,
                    'page_url' => $url,
                    'issue_type' => 'form_error_handling',
                    'severity' => 'minor',
                    'wcag_level' => 'A',
                    'wcag_rule' => '3.3.1',
                    'description' => 'Form may not properly announce errors to screen readers',
                    'fix_suggestion' => 'Use aria-describedby or aria-errormessage to associate error messages with form fields',
                    'code_before' => '<input type="email">',
                    'code_after' => '<input type="email" aria-describedby="email-error"><span id="email-error" role="alert">Invalid email</span>'
                ]);
            }
        });
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
