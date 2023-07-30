<?php

namespace App\Http\Controllers;

use App\Emuns\PageName;
use App\Models\Provider;
use App\Services\ArticlesService;

class ProviderController extends Controller
{
    public function __invoke(Provider $provider, ArticlesService $service)
    {
        return view('provider')
            ->with([
                'providers' => $service->getProvider($provider),
                'providerId' => $provider->id,
                'callPage' => PageName::Provider->value,
            ]);
    }
}
