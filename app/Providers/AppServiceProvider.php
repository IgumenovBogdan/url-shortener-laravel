<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\GoogleSafebrowsingService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GoogleSafebrowsingService::class, function (Application $app) {
            $config = $app['config']['google']['safebrowsing'];
            return new GoogleSafebrowsingService($config['api_key'], $config['client_id'], $config['client_version'], $config['url']);
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
