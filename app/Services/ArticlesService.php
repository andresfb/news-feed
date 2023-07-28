<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Provider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ArticlesService
{
    public function getRandomList(): Collection
    {
        return Cache::remember(
            'all-articles',
            now()->addMinutes(config('articles.cache_ttl_minutes')),
            static function () {
                $articles = collect();
                $providers = Provider::whereStatus(true)->get();

                // TODO: remove the display_counts field from the providers table
                // TODO: add a new feed_counts table related to Feed to add all the counts
                // TODO: when creating the feed_counts records, for the all_news page, increase the number of articles for the news based feeds, take out all the Private feeds.
                // TODO: add the NYT feeds and reduce the number of articles for El Tiempo.

                foreach ($providers as $provider) {
                    $feeds = $provider->feeds()
                        ->whereStatus(true)
                        ->get();

                    foreach ($feeds as $feed) {
                        // TODO: this check should be unnecessary once the feed_counts table is added
                        if ($provider->allNewsCount === 0) {
                            continue;
                        }

                        // TODO: join the new feed_counts table to load the counts
                        // TODO: replace the $provider->allNewsCount with the new feed_counts table count field
                        $articles->push($feed->articles()
                            ->with('tags')
                            ->with('feed')
                            ->with('feed.provider')
                            ->whereNull('read_at')
                            // TODO: make the hours to go back a config value and increase 8 horus
                            ->where('created_at', '>=', now()->subHours(6))
                            ->latest()
                            ->limit($provider->allNewsCount * 5)
                            ->get()
                            ->shuffle()
                            ->take($provider->allNewsCount)
                        );
                    }
                }

                return $articles->flatten()->shuffle()->map(function (Article $article) {
                    return [
                        'id' => $article->id,
                        'title' => $article->title,
                        'link' => route('track', $article->id),
                        'content' => $article->description ?? $article->content,
                        'thumbnail' => $article->thumbnail,
                        'provider' => $article->feed->provider->name,
                        'provider_link' => $article->feed->provider->home_page ?? '',
                        'feed' => $article->feed->title,
                        'tags' => $article->tags->pluck('name')->implode(', '),
                        'published_at' => $article->published_at->diffForHumans(),
                    ];
                });
        });
    }
}
