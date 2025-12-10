<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Scan;

class ProcessWebsiteScan implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $scan;

    /**
     * Create a new job instance.
     */
    public function __construct(Scan $scan)
    {
        $this->scan = $scan;
    }

    /**
     * Execute the job.
     */
    public function handle(AccessibilityScanner $scanner)
    {
        try {
            $this->scan->update(['status' => 'processing']);

            // Run the scanner
            $scanner->scan($this->scan);

            // Update scan status
            $this->scan->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);

            // Update website last scan info
            $this->scan->website->update([
                'last_scan_score' => $this->scan->accessibility_score,
                'last_scanned_at' => now()
            ]);
        } catch (\Exception $e) {
            $this->scan->update(['status' => 'failed']);
            \Log::error('Scan failed: ' . $e->getMessage());
        }
    }
}
