<?php

namespace App\Jobs;

use App\Services\MarkArticleReadService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MarkArticleReadJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly int $articleId, private readonly string $callPage)
    {
    }

    public function handle(MarkArticleReadService $service): void
    {
        try {
            $service->markRead($this->articleId, $this->callPage);
        } catch (Exception $e) {
            report($e);
        }
    }
}
