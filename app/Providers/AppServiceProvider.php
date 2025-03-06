<?php

namespace App\Providers;

use App\Models\Poster;
use App\Models\User;
use App\Repositories\CategoryRespository;
use App\Repositories\PosterRepository;
use App\Repositories\RegionRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RegionRepository::class, function ($app) {
            return new RegionRepository();
        });
        $this->app->bind(CategoryRespository::class, function ($app) {
            return new CategoryRespository();
        });
        $this->app->bind(PosterRepository::class, function ($app) {
            return new PosterRepository($app->make(Poster::class));
        });
        $this->app->bind(UserRepository::class, function ($app) {
            return new UserRepository($app->make(User::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
