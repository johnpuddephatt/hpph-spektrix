<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Dashboards\Main;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Panel;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \OptimistDigital\NovaSettings\NovaSettings::addSettingsFields(
            [
                Text::make("Google analytics"),
                Text::make("Spektrix domain"),
                Text::make("Newsletter signup"),
            ],
            [],
            "Services"
        );
        \OptimistDigital\NovaSettings\NovaSettings::addSettingsFields(
            [
                Text::make("Phone"),
                Textarea::make("Address"),
                Textarea::make("Email"),
                Panel::make("Social media", [
                    Text::make("Facebook"),
                    Text::make("Twitter"),
                    Text::make("Instagram"),
                ]),
            ],
            [],
            "Contact Details"
        );

        \OptimistDigital\NovaSettings\NovaSettings::addSettingsFields(
            [
                Text::make("Message"),
                Text::make("Link"),
                Boolean::make("Enabled?"),
                DateTime::make("Display until"),
            ],
            [],
            "Alert"
        );

        parent::boot();
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
            new \OptimistDigital\NovaSettings\NovaSettings(),
            new \Spatie\BackupTool\BackupTool(),
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
