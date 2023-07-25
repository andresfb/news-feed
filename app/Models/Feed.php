<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
