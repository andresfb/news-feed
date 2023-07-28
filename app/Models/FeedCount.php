<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedCount extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'feed_id',
        'page',
        'count',
    ];

    protected $casts = [
        'feed_id' => 'integer',
        'count' => 'integer',
    ];

    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }
}
