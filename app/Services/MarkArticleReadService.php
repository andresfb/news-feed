<?php

namespace App\Services;

use App\Emuns\PageName;
use App\Models\Article;
use Illuminate\Support\Facades\Cache;

class MarkArticleReadService
{
    public function markRead(int $articleId, string $callPage): void
    {
        $article = Article::GetArticle()
            ->whereId($articleId)
            ->with('feed')
            ->with('feed.provider')
            ->first();

        if ($article === null) {
            return;
        }

        $article->update([
            'read_at' => now()
        ]);

        if ($callPage === PageName::AllNews->value) {
            $this->markReadAllNews($article, $callPage);
            return;
        }

        Cache::tags($callPage)->flush();
    }

    private function markReadAllNews(Article $article, string $callPage): void
    {
        $articles = Cache::tags($callPage)->get($callPage);
        if ($articles === null) {
            return;
        }

        $list = $articles->map(function ($item) use ($article) {
            if ($item['id'] === $article['id']) {
                $item = null;
            }

            return $item;
        })
        ->reject(function ($item) {
            return $item === null;
        });

        foreach (PageName::values() as $value) {
            if ($value === $callPage) {
                continue;
            }

            Cache::tags($value)->flush();
        }

        Cache::tags($callPage)
            ->put($callPage, $list, now()->addMinutes(config('articles.cache_ttl_minutes')));
    }
}
