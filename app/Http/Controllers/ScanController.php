<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Scan;
use App\Jobs\ProcessWebsiteScan;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class ScanController extends BaseController
{
    use AuthorizesRequests;

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
            \Log::info('Existing scan found', ['scan_id' => $existingScan->id, 'status' => $existingScan->status]);
            return redirect()->back()
                ->with('error', 'A scan is already in progress for this website. Please wait for it to complete.');
        }

        \Log::info('Creating new scan for website', ['website_id' => $website->id]);

        // Create new scan
        $scan = Scan::create([
            'website_id' => $website->id,
            'status' => 'pending',
            'started_at' => now()
        ]);

        \Log::info('Scan created', ['scan_id' => $scan->id]);

        // Dispatch job to process scan
        ProcessWebsiteScan::dispatch($scan);

        \Log::info('Job dispatched', ['scan_id' => $scan->id]);

        return redirect()->back()
            ->with('success', 'Scan started! This may take a few minutes. Refresh the page to see results.');
    }

    public function show(Scan $scan)
    {
        $this->authorize('view', $scan->website);

        $issues = $scan->issues()->paginate(20);

        return view('scans.show', compact('scan', 'issues'));
    }
}
