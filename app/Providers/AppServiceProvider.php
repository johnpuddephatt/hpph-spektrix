<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
        // Model::preventLazyLoading(true);

        View::composer("*", function ($view) {
            $view->with(
                "settings",
                \Cache::rememberForever("settings", function () {
                    return nova_get_settings();
                })
            );
        });
        View::composer(["components.strand.menu", 'blocks.home-strands'], function ($view) {
            $view->with(
                "strands",
                \Cache::rememberForever("strands", function () {
                    return \App\Models\Strand::select(
                        "id",
                        "name",
                        "slug",
                        "short_description",
                        "color",
                        "logo"
                    )
                        ->showInProgramme()
                        ->with("featuredImage")
                        ->get();
                })
            );
        });
        View::composer(
            ["sections.navigation", 'blocks.home-seasons'],
            function ($view) {

                $view->with(
                    "seasons",
                    \Cache::rememberForever("seasons", function () {
                        return \App\Models\Season::select(
                            "id",
                            "name",
                            "slug",
                            "short_description",
                        )->showInProgramme()->get();
                    })
                );
            }
        );


        View::composer("sections.header", function ($view) {
            $view->with(
                "programme_page_url",
                \Cache::rememberForever("programme_page_url", function () {
                    return \App\Models\Page::getTemplateUrl("programme-page");
                })
            );
        });

        View::composer(["sections.navigation"], function ($view) {
            $view->with(
                "primary_menu",
                \Cache::rememberForever("primaryMenu", function () {
                    return nova_get_menu_by_slug("primary")
                        ? nova_get_menu_by_slug("primary")["menuItems"]
                        : [];
                })
            );
            $view->with(
                "secondary_menu",
                \Cache::rememberForever("secondaryMenu", function () {
                    return nova_get_menu_by_slug("secondary")
                        ? nova_get_menu_by_slug("secondary")["menuItems"]
                        : [];
                })
            );


            $view->with(
                "tertiary_menu",
                \Cache::rememberForever("tertiaryMenu", function () {
                    return nova_get_menu_by_slug("tertiary")
                        ? nova_get_menu_by_slug("tertiary")["menuItems"]
                        : [];
                })
            );
        });

        \Blade::directive("icon", function ($arguments) {
            // Funky madness to accept multiple arguments into the directive
            list($path, $class) = array_pad(
                explode(",", trim($arguments, "() ")),
                2,
                ""
            );

            $path = trim($path, "' ");
            $class = trim($class, "' ");

            return "{!! str_replace('<svg ', '<svg class=\"{$class}\" ', \Storage::get({$path}) ) !!}";
        });
    }
}
