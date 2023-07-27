<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'home_page',
        'status',
        'display_counts',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'display_counts' => 'json',
        'order' => 'integer',
    ];

    public function feeds(): HasMany
    {
        return $this->hasMany(Feed::class);
    }

    public function allNewsCount(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->display_counts['all_news'] ?? 0,
        );
    }

    public function groupedCount(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->display_counts['grouped'] ?? 0,
        );
    }

    public function providerCount(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->display_counts['provider'] ?? 0,
        );
    }

    public function archiveCount(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->display_counts['archive'] ?? 0,
        );
    }
}
