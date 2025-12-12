<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class WebsiteController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $websites = Auth::user()->websites()->with('latestScan')->get();
        return view('websites.index', compact('websites'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->canAddWebsite()) {
            return redirect()->route('websites.index')
                ->with('error', 'You have reached the maximum number of websites for your plan.');
        }

        return view('websites.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->canAddWebsite()) {
            return redirect()->route('websites.index')
                ->with('error', 'You have reached the maximum number of websites for your plan.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255'
        ]);

        // Normalize URL
        $url = $validated['url'];

        // Add https:// if no scheme provided
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "https://" . $url;
        }

        // Validate if URL is accessible
        try {
            \Log::info('Validating URL', ['url' => $url]);

            $response = \Illuminate\Support\Facades\Http::timeout(15)
                ->withoutVerifying() // Allow self-signed certificates for testing
                ->get($url);

            \Log::info('URL validation response', ['status' => $response->status()]);

            if ($response->status() >= 400 && $response->status() < 600) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Unable to access the website. The site returned HTTP ' . $response->status() . '. Please verify the URL.');
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            \Log::error('Connection error during URL validation', ['url' => $url, 'error' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to connect to the website. Please check if the URL is correct and accessible.');
        } catch (\Exception $e) {
            \Log::error('Error during URL validation', ['url' => $url, 'error' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while validating the URL: ' . $e->getMessage());
        }

        // Store with validated URL
        $validated['url'] = $url;
        $validated['user_id'] = $user->id;

        Website::create($validated);

        return redirect()->route('websites.index')
            ->with('success', 'Website added successfully!');
    }

    public function show(Website $website)
    {
        $this->authorize('view', $website);

        $scans = $website->scans()->with('issues')->latest()->paginate(10);

        return view('websites.show', compact('website', 'scans'));
    }

    public function destroy(Website $website)
    {
        $this->authorize('delete', $website);

        $website->delete();

        return redirect()->route('websites.index')
            ->with('success', 'Website deleted successfully!');
    }
}
