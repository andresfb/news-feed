<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArchiveService
{
    private ?LengthAwarePaginator $articles = null;

    public function getList(int $perPage): Collection
    {
        return $this->getArticles($perPage)->map(function (Article $article) {
            return $article->toArray();
        });
    }

    public function getArticles(int $perPage): LengthAwarePaginator
    {
        if ($this->articles !== null) {
            return $this->articles;
        }

        $this->articles = Article::getArticle()
            ->with('feed')
            ->with('feed.provider')
            ->latest()
            ->paginate($perPage);

        return $this->articles;
    }

    public function getCount(): int
    {
        return Article::count();
    }
}
