<?php

namespace App\Services;

use App\DataObjects\ArticleInfo;
use App\Models\Article;
use App\Models\Feed;
use App\Models\Provider;
use Exception;
use Illuminate\Support\Collection;
use Vedmant\FeedReader\FeedReader;

class FeedsService
{
    public function getFeeds(): Collection
    {
        $providers = Provider::with('feeds')
            ->whereStatus(true)
            ->get();

        if ($providers->isEmpty()) {
            return collect();
        }

        return $providers->map(function (Provider $provider) {
            return $provider->feeds;
        })
        ->flatten()
        ->filter(function (Feed $feed) {
            return $feed->status;
        });
    }

    /**
     * @throws Exception
     */
    public function importFeed(Feed $feed): void
    {
        $reader = resolve(FeedReader::class);
        $result = $reader->read($feed->url);

        if ($result === null || $result->error()) {
            throw new \RuntimeException(
                "@FeedsService.importFeed. Error importing feed: {$feed->url} {$result->error()}"
            );
        }

        foreach ($result->get_items() as $key => $item) {
            $info = ArticleInfo::create(
                item: $item,
                feed: $feed,
                index: $key
            );

            $article = Article::updateOrCreate([
                'feed_id' => $feed->id,
                'hash' => $info->getHash()
            ], $info->toArray());

            if (empty($info->getTags())) {
                continue;
            }

            $article->attachTags($info->getTags());
        }
    }
}
