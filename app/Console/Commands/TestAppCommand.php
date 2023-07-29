<?php

namespace App\Console\Commands;

use App\Services\ArticlesService;
use App\Services\FeedsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestAppCommand extends Command
{
    protected $signature = 'test:app';

    protected $description = 'Run simple tests';

    public function handle(): int
    {
        try {
            $this->info("\nStarting tests");

//            $srv = resolve(FeedsService::class);
//            $feeds = $srv->getFeeds();
//
//            foreach ($feeds as $feed) {
//                $this->info("Feed: {$feed->provider->name} | {$feed->title}");
//                $srv->importFeed($feed);
//            }

            $srv = resolve(ArticlesService::class);
            $articles = $srv->getGrouped();

            dump($articles);

            $this->info("\nDone.\n");

            return 0;
        } catch (\Exception $e) {
            $this->line('');
            $this->error($e->getMessage());
            $this->line('');
            Log::error($e->getMessage());

            return 1;
        }
    }
}
