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
        View::composer("*", function ($view) {
            $view->with(
                "strands_and_seasons",
                \Cache::rememberForever("strands_and_seasons", function () {
                    return \App\Models\Strand::select(
                        "id",
                        "name",
                        "slug",
                        "short_description",
                        "color",
                        "logo",
                        "logo_text"
                    )
                        ->get()
                        ->merge(
                            \App\Models\Season::select(
                                "id",
                                "name",
                                "slug",
                                "short_description"
                            )->get()
                        );
                })
            );
            $view->with(
                "settings",
                \Cache::rememberForever("settings", function () {
                    return nova_get_settings();
                })
            );
            $view->with(
                "header_menu",
                \Cache::rememberForever("headerMenu", function () {
                    return nova_get_menu_by_slug("header")
                        ? nova_get_menu_by_slug("header")["menuItems"]
                        : [];
                })
            );
            $view->with(
                "footer_menu",
                \Cache::rememberForever("footerMenu", function () {
                    return nova_get_menu_by_slug("footer")
                        ? nova_get_menu_by_slug("footer")["menuItems"]
                        : [];
                })
            );
        });
    }
}
