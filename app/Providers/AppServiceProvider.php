<?php

namespace App\Providers;

use App\Services\Contracts\ProductInterface;
use App\Services\FakeApiPlatziService;
use App\Services\FakeStoreApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductInterface::class, function () {
            return env('API_PROVIDER') === 'fakestore'
                ? new FakeStoreApiService()
                : new FakeApiPlatziService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
