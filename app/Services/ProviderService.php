<?php

namespace App\Services;

use App\Models\Provider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProviderService
{
    public function getList(): Collection
    {
        return Cache::tags('providers')->remember(
            'providers',
            now()->addHours(24),
            static function () {
                return Provider::select(['id', 'name'])
                    ->whereStatus(true)
                    ->orderBy('order')
                    ->get()
                    ->pluck('name', 'id');
            }
        );
    }

    public function getRoutes(): Collection
    {
        return Cache::tags('provider-routes')->remember(
            'provider-routes',
            now()->addHours(24),
            function () {
                return $this->getList()->keys()->map(function ($item) {
                    return sprintf('%s/provider/%s', config('app.url'), $item);
                });
            }
        );
    }
}
