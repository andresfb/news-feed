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

                foreach ($providers as $provider) {
                    $feeds = $provider->feeds()
                        ->whereStatus(true)
                        ->get();

                    foreach ($feeds as $feed) {
                        if ($provider->allNewsCount === 0) {
                            continue;
                        }

                        $articles->push($feed->articles()
                            ->with('tags')
                            ->with('feed')
                            ->with('feed.provider')
                            ->whereNull('read_at')
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
