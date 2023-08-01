<?php

namespace App\Jobs;

use App\Services\FeedsService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ImportFeedsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private int $delaySeconds = 0;

    /**
     * @throws Exception
     */
    public function handle(FeedsService $service): void
    {
        try {
            Cache::tags('all_news')->flush();

            $feeds = $service->getFeeds();
            if ($feeds->isEmpty()) {
                Log::info('No feeds to import');
                return;
            }

            foreach ($feeds as $feed) {
                ImportFeedJob::dispatch($feed, $service)
                    ->delay(now()->addSeconds($this->delaySeconds));

                $this->delaySeconds += 5;
            }
        } catch (Exception $e) {
            Log::error('@ImportFeedsJob.handle'.$e->getMessage());
            throw $e;
        }
    }
}
