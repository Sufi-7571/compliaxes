<?php

namespace App\Jobs;

use App\Models\Scan;
use App\Services\AxeCoreScanner;
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
    public $timeout = 600; // 10 minutes timeout

    public function __construct(Scan $scan)
    {
        $this->scan = $scan;
    }

    public function handle()
    {
        try {
            Log::info('Starting axe-core scan job', ['scan_id' => $this->scan->id]);
            
            $this->scan->update(['status' => 'processing']);
            
            // Use AxeCoreScanner instead
            $scanner = new AxeCoreScanner();
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
            
            Log::info('Scan completed successfully', ['scan_id' => $this->scan->id]);
            
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