<?php

namespace App\Jobs;

use App\Models\Feed;
use App\Services\FeedsService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportFeedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly Feed $feed, private readonly FeedsService $service)
    {
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        try {
            $this->service->importFeed($this->feed);
        } catch (Exception $e) {
            Log::error('@ImportFeedJob.handle'.$e->getMessage());
            throw $e;
        }
    }
}
