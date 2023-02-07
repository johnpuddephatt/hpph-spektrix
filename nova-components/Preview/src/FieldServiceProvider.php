<?php

namespace Jdp\Preview;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Route;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script("preview", __DIR__ . "/../dist/js/field.js");
            // Nova::style(
            //     "preview",
            //     \Illuminate\Support\Facades\Vite::asset("resources/css/app.css")
            // );
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(["nova"])
            ->prefix("nova-vendor/view")
            ->group(__DIR__ . "/../routes/api.php");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
