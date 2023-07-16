<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Vedmant\FeedReader\FeedReader;

class TestAppCommand extends Command
{
    protected $signature = 'test:app';

    protected $description = 'Run simple tests';

    public function handle(): int
    {
        try {
            $this->info("\nStarting tests");

//            $path = storage_path('app/public/example.pdf');
//            $html = Browsershot::url('https://www.npr.org/sections/health-shots/2023/07/15/1184298351/conception-human-eggs-ivg-ivf-infertility')
//                ->noSandbox()
//                ->setRemoteInstance('192.168.1.49')
//                ->waitUntilNetworkIdle()
//                ->bodyHtml();
//
//            Browsershot::url('https://www.npr.org/sections/health-shots/2023/07/15/1184298351/conception-human-eggs-ivg-ivf-infertility')
//                ->noSandbox()
//                ->setRemoteInstance('192.168.1.49')
//                ->waitUntilNetworkIdle()
//                ->format('Letter')
//                ->savePdf($path);



//            $f = resolve(FeedReader::class);
////            $r = $f->read('https://news.google.com/news/rss');
////            $r = $f->read('https://www.techmeme.com/feed.xml');
////            $r = $f->read('https://news.ycombinator.com/rss');
////            $r = $f->read('https://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml');
////            $r = $f->read('https://rss.nytimes.com/services/xml/rss/nyt/Technology.xml');
////            $r = $f->read('https://feeds.arstechnica.com/arstechnica/index');
////            $r = $f->read('https://www.metacritic.com/rss');
////            $r = $f->read('https://feeds.npr.org/1001/rss.xml');
////            $r = $f->read('https://wsvn.com/feed/');
//
//            echo $r->get_title() . PHP_EOL . PHP_EOL;
//
//            foreach ($r->get_items() as $item) {
//                echo "Title: " . $item->get_title() . PHP_EOL . PHP_EOL;
//                echo "Description: " . $item->get_description() . PHP_EOL . PHP_EOL;
//                echo "Link: " . $item->get_permalink() . PHP_EOL . PHP_EOL;
//                echo "Content: " . $item->get_content() . PHP_EOL . PHP_EOL;
//                if (is_array($item->get_thumbnail())) {
//                    echo print_r($item->get_thumbnail(), true) . PHP_EOL . PHP_EOL;
//                } else {
//                    echo "Thumbnail: " . $item->get_thumbnail() . PHP_EOL . PHP_EOL;
//                }
//                echo "Base: " . $item->get_base() . PHP_EOL . PHP_EOL;
//                echo "Source: " . $item->get_source() . PHP_EOL . PHP_EOL;
//                $this->line("\n");
//            }
//
//            $this->info(count($r->get_items()));

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
