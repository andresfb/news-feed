<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Feed;
use App\Models\Provider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ArchiveService
{
    private int $articleCount = 0;

    private array $params = [];

    private ?LengthAwarePaginator $articles = null;

    public function getList(): Collection
    {
        return $this->getArticles()->map(function (Article $article) {
            return $article->toArray();
        });
    }

    public function getArticles(): LengthAwarePaginator
    {
        if ($this->articles !== null) {
            return $this->articles;
        }

        $query = Article::getArticle()
            ->with('feed')
            ->with('feed.provider')
            ->orderBy('created_at');

        if ($this->feedId() > 0) {
            $query->whereFeedId($this->feedId());
        } elseif ($this->providerId() > 0) {
            $query->whereHas('feed', function ($query) {
                $query->whereProviderId($this->providerId());
            });
        }

        if ($this->fromDate() !== null) {
            $query->whereDate('created_at', '>=', $this->fromDate());
        }

        if ($this->toDate() !== null) {
            $query->whereDate('created_at', '<=', $this->toDate());
        }

        $this->articleCount = $query->count();

        $this->articles = $query->paginate($this->perPage());

        return $this->articles;
    }

    public function getFeeds(): array
    {
        if (empty($this->providerId())) {
            return [];
        }

        return Feed::select(['id', 'title'])
            ->whereProviderId($this->providerId())
            ->orderBy('order')
            ->get()
            ->toArray();
    }

    public function getArticleCount(): int
    {
        return $this->articleCount;
    }

    public function setParameters(array $params): void
    {
        $this->params = $params;
    }

    public function perPage(): int
    {
        return $this->params['per_page'] ?? 50;
    }

    public function providerId(): int
    {
        return $this->params['provider'] ?? 0;
    }

    public function provider(): string
    {
        if (empty($this->params['provider'])) {
            return 'All Articles';
        }

        return Provider::find($this->params['provider'])->name;
    }

    public function feedId(): int
    {
        return $this->params['feed'] ?? 0;
    }

    public function fromDate(): ?Carbon
    {
        if (empty($this->params['from_date'])) {
            return null;
        }

        return Carbon::parse($this->params['from_date']);
    }

    public function toDate(): ?Carbon
    {
        if (empty($this->params['to_date'])) {
            return null;
        }

        return Carbon::parse($this->params['to_date']);
    }
}
