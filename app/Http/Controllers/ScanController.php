<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Scan;
use App\Jobs\ProcessWebsiteScan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class ScanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('view', $website);

        // Check if there's already a pending or processing scan
        $existingScan = $website->scans()
            ->whereIn('status', ['pending', 'processing'])
            ->first();

        if ($existingScan) {
            return redirect()->back()
                ->with('error', 'A scan is already in progress for this website.');
        }

        // Create new scan
        $scan = Scan::create([
            'website_id' => $website->id,
            'status' => 'pending',
            'started_at' => now()
        ]);

        // Dispatch job to process scan
        ProcessWebsiteScan::dispatch($scan);

        return redirect()->back()
            ->with('success', 'Scan started! This may take a few minutes.');
    }

    public function show(Scan $scan)
    {
        $this->authorize('view', $scan->website);

        $issues = $scan->issues()->paginate(20);

        return view('scans.show', compact('scan', 'issues'));
    }
}
