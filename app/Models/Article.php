<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'feed_id',
        'title',
        'permalink',
        'content',
        'description',
        'thumbnail',
        'data',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

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
}
