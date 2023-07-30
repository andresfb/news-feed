<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Article extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasTags;

    protected $fillable = [
        'feed_id',
        'hash',
        'title',
        'permalink',
        'content',
        'description',
        'thumbnail',
        'data',
        'read_at',
        'published_at',
    ];

    protected $hidden = ['data'];

    protected $casts = [
        'data' => 'json',
        'read_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function scopeGetArticle(Builder $query): Builder
    {
        return $query->select([
            'id',
            'feed_id',
            'hash',
            'title',
            'permalink',
            'content',
            'description',
            'thumbnail',
            'read_at',
            'published_at',
            'deleted_at',
            'created_at',
            'updated_at',
        ]);
    }

    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }

    public function registerMediaCollections(): void
    {
        $mediaDisk = config('media-library.disk_name');

        $this->addMediaCollection('pdf')
            ->singleFile()
            ->useDisk($mediaDisk);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'permalink' => $this->permalink,
            'content' => $this->description ?? $this->content,
            'thumbnail' => $this->thumbnail,
            'provider' => $this->feed->provider->name,
            'provider_link' => $this->feed->provider->home_page ?? '',
            'feed' => $this->feed->title,
            'tags' => $this->tags->pluck('name')->implode(', '),
            'read_at' => $this->read_at ? $this->read_at->diffForHumans() : null,
            'published_at' => $this->published_at->diffForHumans(),
        ];
    }
}
