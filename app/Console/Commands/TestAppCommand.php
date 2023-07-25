<?php

namespace App\Console\Commands;

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
