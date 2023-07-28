<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Feed extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'provider_id',
        'title',
        'url',
        'status',
        'refreshed_at',
    ];

    protected $casts = [
        'refreshed_at' => 'datetime',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function counts(): HasMany
    {
        return $this->hasMany(FeedCount::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function scopeWithActiveProvider(Builder $query): Builder
    {
        return $query->whereHas('provider', static function (Builder $query) {
            $query->where('status', true);
        });
    }

    public function scopeWithFeedCount(Builder $query, string $page): Builder
    {
        return $query->select([
            'feeds.*',
            DB::raw("feed_counts.count as feed_count")
        ])
        ->join('feed_counts', 'feed_counts.feed_id', '=', 'feeds.id')
        ->where('feed_counts.page', $page)
        ->where('feed_counts.count', '>', 0);
    }
}
