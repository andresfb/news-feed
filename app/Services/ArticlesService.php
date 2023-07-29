<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Feed;
use App\Models\Provider;
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
                $feeds = Feed::withActiveProvider()
                    ->withFeedCount('all_news')
                    ->whereStatus(true)
                    ->get();

                $articles = collect();
                foreach ($feeds as $feed) {
                    $items = $this->getArticles($feed, 'all_news');
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
            }
        );
    }

    public function getGrouped(): Collection
    {
        return Cache::tags('grouped')->remember(
            'grouped',
            now()->addMinutes(config('articles.cache_ttl_minutes')),
            function () {
                $providers = Provider::whereStatus(true)
                    ->orderBy('order')
                    ->get();

                if ($providers->isEmpty()) {
                    return collect();
                }

                $groups = [];
                foreach ($providers as $provider) {
                    $groups[] = $this->getProviderInfo($provider, 'grouped');
                }

                return collect($groups);
            }
        );
    }

    public function getProvider(Provider $provider): Collection
    {
        return Cache::tags('provider')->remember(
            "provider_{$provider->id}",
            now()->addMinutes(config('articles.cache_ttl_minutes')),
            function () use ($provider){
                $groups[] = $this->getProviderInfo($provider, 'provider');

                return collect($groups);
            }
        );
    }

    private function getProviderInfo(Provider $provider, string $callPage): array
    {
        return [
            'id' => $provider->id,
            'name' => $provider->name,
            'provider_link' => $provider->home_page ?? '',
            'feeds' => $this->getFeeds($provider->id, $callPage)
        ];
    }

    private function getFeeds(int $providerId, string $callPage): array
    {
        $feeds = Feed::whereProviderId($providerId)
            ->withFeedCount($callPage)
            ->whereStatus(true)
            ->orderBy('order')
            ->get();

        if ($feeds->isEmpty()) {
            return [];
        }

        $list = [];
        foreach ($feeds as $feed) {
            $list[] = [
                'title' => $feed->title,
                'logo' => $feed->logo,
                'articles' => $this->getArticles($feed, $callPage)->map(function (Article $article) {
                    return $this->getFeedData($article);
                })->toArray(),
            ];
        }

        return $list;
    }

    private function getArticles($feed, string $callPage): Collection
    {
        return $feed->articles()
            ->with('tags')
            ->with('feed')
            ->with('feed.provider')
            ->whereNull('read_at')
            ->where(
                'updated_at',
                '>=',
                now()->subHours(config("articles.hours_to_go_back.$callPage"))
            )
            ->latest()
            ->groupBy('id')
            ->limit($feed->feed_count * 5)
            ->get()
            ->shuffle()
            ->take($feed->feed_count);
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
