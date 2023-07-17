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
////            $r = $f->read('https://www.youtube.com/feeds/videos.xml?channel_id=UCD88k6KX9chc-KgEOuSJSVw');
//            $r = $f->read('http://private-feeds.lan/feeds/videos');
//
//            echo $r->get_title() . PHP_EOL . PHP_EOL;
//
//            foreach ($r->get_items() as $item) {
//                echo "Id: " . $item->get_id() . PHP_EOL . PHP_EOL;
//                echo "Title: " . $item->get_title() . PHP_EOL . PHP_EOL;
//                echo "Content: " . $item->get_content() . PHP_EOL . PHP_EOL;
//                echo "Description: " . $item->get_description() . PHP_EOL . PHP_EOL;
//                echo "Enclosure Description: " . $item->get_enclosure()?->description . PHP_EOL . PHP_EOL;
//                echo "Link: " . $item->get_permalink() . PHP_EOL . PHP_EOL;
//                if (is_array($item->get_thumbnail())) {
//                    echo print_r($item->get_thumbnail(), true) . PHP_EOL . PHP_EOL;
//                } else {
//                    echo "Thumbnail: " . $item->get_thumbnail() . PHP_EOL . PHP_EOL;
//                }
//                echo "Enclosure Thumbnails: " . print_r($item->get_enclosure()?->thumbnails, true) . PHP_EOL . PHP_EOL;
//                echo "Date: " . $item->get_date('Y-m-d H:i:s') . PHP_EOL . PHP_EOL;
//                echo "Author: " . $item->get_author()?->name . PHP_EOL . PHP_EOL;
//                echo "Categories: " . print_r($item->get_categories(), true) . PHP_EOL . PHP_EOL;
//                //echo "Enclosures: " . print_r($item->get_enclosures(), true) . PHP_EOL . PHP_EOL;
//                //echo "Links: " . print_r($item->get_links(), true) . PHP_EOL . PHP_EOL;
//                //echo "Data: " . trim($item->data['child']['http://www.w3.org/2005/Atom']['summary'][0]['data']) . PHP_EOL . PHP_EOL;
//                //echo "Data: " . print_r($item->data, true) . PHP_EOL . PHP_EOL;
//
//                $this->line("\n");
//                break;
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
