<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Dashboards\Main;
use Spatie\MediaLibraryPro\Models\TemporaryUpload;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\Image\Manipulations;
use Illuminate\Http\Request;

use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (config("nova-settings-config") as $settings) {
            \Outl1ne\NovaSettings\NovaSettings::addSettingsFields(
                $settings["fields"] ?? [],
                $settings["casts"] ?? [],
                $settings["page"] ?? null
            );
        }

        parent::boot();

        Nova::footer(function ($request) {
            return "<style>html:not(.dark) [data-testid='content'] > div:nth-of-type(1) { padding-bottom: 6rem; min-height: 100%; background-color: rgb(220,230,240);} #nova { position: relative;} header {box-shadow: rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.1) 0px 1px 2px -1px}</style>";
        });

        // Nova::mainMenu(function (Request $request, Menu $menu) {
        //     return $menu->append(MenuSection::resource(\App\Nova\User::class));
        // });

        Nova::mainMenu(function (Request $request, Menu $menu) {
            return [
                MenuSection::dashboard(\App\Nova\Dashboards\Main::class)->icon(
                    "eye"
                ),
                MenuSection::make("Content", [
                    MenuGroup::make("Programme", [
                        MenuItem::resource(\App\Nova\Event::class)->withBadgeIf(
                            \App\Models\Event::unpublished()->count() . " new",
                            "info",
                            fn() => \App\Models\Event::unpublished()->count() >
                                0
                        ),
                        MenuItem::resource(\App\Nova\Strand::class),
                        MenuItem::resource(\App\Nova\Season::class),
                    ]),

                    MenuGroup::make("Posts & pages", [
                        MenuItem::resource(\App\Nova\Page::class),
                        MenuItem::resource(\App\Nova\Post::class),
                    ]),

                    MenuGroup::make("", [
                        MenuItem::resource(\App\Nova\Membership::class),
                    ]),
                ]),
                MenuSection::make(__("novaMenuBuilder.sidebarTitle"))
                    ->path("/menus")
                    ->icon("menu"),
                (new \Outl1ne\NovaSettings\NovaSettings())->menu($request),

                MenuSection::resource(\App\Nova\User::class)->icon("user"),
                (new \Spatie\BackupTool\BackupTool())->menu($request),
            ];
        });
        // in a service provider
        TemporaryUpload::previewManipulation(function (Conversion $conversion) {
            $conversion->fit(Manipulations::FIT_CROP, 1200, 900);
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define("viewNova", function ($user) {
            return true;
        });
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [new Main()];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            // new \Acme\Test\Test(),
            \Outl1ne\MenuBuilder\MenuBuilder::make(),
            new \Outl1ne\NovaSettings\NovaSettings(),
            new \Spatie\BackupTool\BackupTool(),
            new \Stepanenko3\LogsTool\LogsTool(),
        ];
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
