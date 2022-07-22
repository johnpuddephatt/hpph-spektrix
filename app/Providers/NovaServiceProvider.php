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
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;

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
            \OptimistDigital\NovaSettings\NovaSettings::addSettingsFields(
                $settings["fields"] ?? [],
                $settings["casts"] ?? [],
                $settings["page"] ?? null
            );
        }

        parent::boot();

        Nova::footer(function ($request) {
            return "<style>div.lg\:top-\[56px\] { padding-bottom: 6rem; min-height: 100%; background: rgb(0,0,40);} #nova { position: relative;} header {box-shadow: rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.1) 0px 1px 2px -1px}</style>";
        });

        // Nova::mainMenu(function (Request $request, Menu $menu) {
        //     return $menu->append(MenuSection::resource(\App\Nova\User::class));
        // });

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
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [new Help()];
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
            new \OptimistDigital\NovaSettings\NovaSettings(),
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
