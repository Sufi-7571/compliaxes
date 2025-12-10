<?php

namespace App\Jobs;

use App\Models\Scan;
use App\Services\AccessibilityScanner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessWebsiteScan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $scan;

    public function __construct(Scan $scan)
    {
        $this->scan = $scan;
    }

    public function handle()
    {
        try {
            Log::info('Starting scan', ['scan_id' => $this->scan->id]);

            $this->scan->update(['status' => 'processing']);

            // Run the scanner
            $scanner = new AccessibilityScanner();
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

            Log::info('Scan completed', ['scan_id' => $this->scan->id]);
        } catch (\Exception $e) {
            $this->scan->update(['status' => 'failed']);
            Log::error('Scan failed', [
                'scan_id' => $this->scan->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Job failed completely', [
            'scan_id' => $this->scan->id,
            'error' => $exception->getMessage()
        ]);

        $this->scan->update(['status' => 'failed']);
    }
}
