<?php

namespace App\Providers;

use App\Classes\Article;
use App\Models\Product;
use App\Policies\SamplePolicy;
use App\Services\Service1;
use App\Services\Service2;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\VarDumper\VarDumper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // $this->app->singleton(Product::class, function ($app) {
        //     var_dump('single');
        //     return new Product();
        // });
        $this->app->bind(Service1::class, function () {
            var_dump('sajiosjc');
            return  new Service2;
        });
        $this->app->bind(Service2::class, function () {
            var_dump('sajiosjc');
            return  new Service2;
        });

        if (in_array($this->app->environment(), ['local', 'development'], true) && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::policy(Article::class, SamplePolicy::class);
    }
}
