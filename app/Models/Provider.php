<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'Name',
        'Description',
        'home_page',
    ];

    public function feeds(): HasMany
    {
        return $this->hasMany(Feed::class);
    }
}
