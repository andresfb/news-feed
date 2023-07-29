<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Feed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ArticlesService
{
    public function getRandomList(): Collection
    {
        return Cache::tags('all_news')->remember(
            'all_news',
            now()->addMinutes(config('articles.cache_ttl_minutes')),
            function () {
                $articles = collect();
                $feeds = Feed::withActiveProvider()
                    ->withFeedCount('all_news')
                    ->whereStatus(true)
                    ->get();

                foreach ($feeds as $feed) {
                    $items = $feed->articles()
                        ->with('tags')
                        ->with('feed')
                        ->with('feed.provider')
                        ->whereNull('read_at')
                        ->where(
                            'updated_at',
                            '>=',
                            now()->subHours(config('articles.hours_to_go_back.all_news'))
                        )
                        ->latest()
                        ->groupBy('id')
                        ->limit($feed->feed_count * 5)
                        ->get()
                        ->shuffle()
                        ->take($feed->feed_count);

                    if ($items->isEmpty()) {
                        continue;
                    }

                    $articles->push($items);
                }

                return $articles->flatten()
                    ->unique('id')
                    ->shuffle()
                    ->map(function (Article $article) {
                        return $this->getFeedData($article);
                });
        });
    }

    private function getFeedData(Article $article): array
    {
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
    }
}
