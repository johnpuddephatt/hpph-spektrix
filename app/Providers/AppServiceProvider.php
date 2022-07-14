<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Outl1ne\MenuBuilder\Models\MenuItem::observe(
            \App\Observers\MenuItemObserver::class
        );
        \Outl1ne\MenuBuilder\Models\Menu::observe(
            \App\Observers\MenuObserver::class
        );

        Blade::directive("webComponent", function ($component) {
            if (!isset($spektrix_web_components)) {
                $spektrix_web_components = [];
            }
            $web_components = config("spektrix_web_components") ?? [];
            array_push($web_components, ...explode(",", $component));

            config([
                "spektrix_web_components" => $web_components,
            ]);
        });

        Blade::directive("getWebComponents", function () {
            if (config("spektrix_web_components")) {
                return Str::of(implode(",", config("spektrix_web_components")))
                    ->replace('\'', "")
                    ->replace(" ", "");
            } else {
                return "";
            }
        });

        View::composer("*", function ($view) {
            $view->with(
                "header_menu",
                \Cache::rememberForever("headerMenu", function () {
                    return nova_get_menu_by_slug("header")
                        ? nova_get_menu_by_slug("header")["menuItems"]
                        : [];
                })
            );
        });
    }
}
