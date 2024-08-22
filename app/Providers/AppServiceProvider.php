<?php

namespace App\Providers;

use App\Repositories\EmiRepository;
use App\Repositories\EmiRepositoryInterface;
use App\Services\EmiServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmiRepositoryInterface::class, EmiRepository::class);
        $this->app->bind(EmiServices::class, function ($app) {
            return new EmiServices($app->make(EmiRepositoryInterface::class));
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
