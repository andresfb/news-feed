<?php

namespace App\Models;

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
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function feeds(): HasMany
    {
        return $this->hasMany(Feed::class);
    }
}
