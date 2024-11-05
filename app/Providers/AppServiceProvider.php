<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\AttributeOption\AttributeOptionRepository;
use App\Repositories\AttributeOption\AttributeOptionRepositoryInterface;
use App\Repositories\CategoryAttribute\CategoryAttributeRepository;
use App\Repositories\CategoryAttribute\CategoryAttributeRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        // Manually
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(AttributeOptionRepositoryInterface::class, AttributeOptionRepository::class);
        $this->app->bind(CategoryAttributeRepositoryInterface::class, CategoryAttributeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
