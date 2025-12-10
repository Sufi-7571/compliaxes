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
