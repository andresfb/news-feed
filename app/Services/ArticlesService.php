<?php

namespace App\Services;

use App\Emuns\PageName;
use App\Models\Article;
use App\Models\Feed;
use App\Models\Provider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ArticlesService
{
    public function getRandomList(): Collection
    {
        return Cache::tags(PageName::AllNews->value)->remember(
            PageName::AllNews->value,
            now()->addMinutes(config('articles.cache_ttl_minutes')),
            function () {
                $feeds = Feed::withActiveProvider()
                    ->withFeedCount(PageName::AllNews->value)
                    ->whereStatus(true)
                    ->get();

                $articles = collect();
                foreach ($feeds as $feed) {
                    $items = $this->getArticles($feed, PageName::AllNews->value);
                    if ($items->isEmpty()) {
                        continue;
                    }

                    $articles->push($items);
                }

                return $articles->flatten()
                    ->unique('id')
                    ->shuffle()
                    ->map(function (Article $article) {
                        return $article->toArray();
                    });
            }
        );
    }

    public function getGrouped(): Collection
    {
        return Cache::tags(PageName::Grouped->value)->remember(
            PageName::Grouped->value,
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
                    $groups[] = $this->getProviderInfo($provider, PageName::Grouped->value);
                }

                return collect($groups);
            }
        );
    }

    public function getProvider(Provider $provider): Collection
    {
        return Cache::tags(PageName::Provider->value)->remember(
            sprintf("%s_%s", PageName::Provider->value, $provider->id),
            now()->addMinutes(config('articles.cache_ttl_minutes')),
            function () use ($provider){
                $groups[] = $this->getProviderInfo($provider, PageName::Provider->value);

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
                    return $article->toArray();
                })->toArray(),
            ];
        }

        return $list;
    }

    private function getArticles($feed, string $callPage): Collection
    {
        return $feed->articles()
            ->GetArticle()
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
}
