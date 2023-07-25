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
//        return Cache::remember('all-articles', now()->addMinutes(30), static function () {
            $articles = collect();
            $providers = Provider::whereStatus(true)->get();

            foreach ($providers as $provider) {
                $feeds = $provider->feeds()
                    ->whereStatus(true)
                    ->get();

                foreach ($feeds as $feed) {
                    $articles->push($feed->articles()
                        ->with('tags')
                        ->with('feed')
                        ->with('feed.provider')
                        ->whereNull('read_at')
                        ->where('created_at', '>=', now()->startOfDay())
                        ->latest()
                        ->limit(30)
                        ->get()
                        ->shuffle()
                        ->take((int)config('articles.random_count'))
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
                    'feed' => $article->feed->title,
                    'tags' => $article->tags->pluck('name')->toArray(),
                    'created_at' => $article->created_at->diffForHumans(),
                ];
            });
//        });
    }
}
