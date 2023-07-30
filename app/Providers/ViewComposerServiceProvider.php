<?php

namespace App\Providers;

use App\Emuns\PageName;
use App\Services\ProviderService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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

            foreach (PageName::array() as $value => $name) {
                view()->share(
                    Str::of($name)->camel()->toString() . 'Menu',
                    $value
                );
            }
        }
    }
}
