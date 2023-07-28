<?php

namespace App\Providers;

use App\Services\ProviderService;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    private readonly ProviderService $providerService;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->providerService = resolve(ProviderService::class);
    }

    public function register(): void
    {

    }

    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            view()->share('providers', $this->providerService->getList());

            view()->share('providerRoutes', $this->providerService->getRoutes());
        }
    }
}
