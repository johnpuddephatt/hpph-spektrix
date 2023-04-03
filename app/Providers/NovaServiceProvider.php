<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Dashboards\Main;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\Image\Manipulations;
use Illuminate\Http\Request;
use Advoor\NovaEditorJs\NovaEditorJs;
use Illuminate\Support\Facades\Vite;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
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
        parent::boot();

        $settings = [
            new \App\Nova\Settings\Alert(),
            new \App\Nova\Settings\Banner(),
            new \App\Nova\Settings\Contact(),
            new \App\Nova\Settings\Messages(),
            new \App\Nova\Settings\System(),
            // new \App\Nova\Settings\Newsletter(),
        ];

        foreach ($settings as $setting) {
            \Outl1ne\NovaSettings\NovaSettings::addSettingsFields(
                $setting->fields() ?? [],
                $setting->casts() ?? [],
                $setting->page ?? null
            );
        }

        Nova::serving(function () {
            Nova::script(
                "editorjs-plugins",
                Vite::asset("resources/js/editorjs-plugins.js")
            );
        });

        Nova::footer(function ($request) {
            return "
            <style>
                html:not(.dark) [data-testid='content'] > div:nth-of-type(1) { padding-bottom: 6rem; min-height: 100%; background-image: linear-gradient(to bottom, rgb(220,230,240), transparent);}
                #nova { position: relative;}
                header {box-shadow: rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.1) 0px 1px 2px -1px}
                .editor-js, #editor-js-content {
                    padding-top: 0.5rem;
                    padding-bottom: 0.5rem;
                    border-radius: 0.25rem;
                    box-shadow: none;
                    width: 73.75%;
                }
                .ce-toolbar__content,
                .ce-block__content {
                    margin-left: 0;
                }

                .ce-toolbar__actions {
                    margin-right: 2rem !important;
                }

                .md\:pt-2  > .editor-js, .md\:pt-2  > #editor-js-content {
                    padding-top: 3rem;
                    border: none;
                    box-shadow: none;
                    width: calc(125% + 4rem);
                    padding-left: 0;
                    margin-left: -2rem;
                    margin-right: -2rem;
                    margin-top: -2.2rem;
                    background-color: white;
                    color: inherit;
                    font-size: 1.25rem;
                    line-height: 1.5;
                }
                .md\:pt-2 .ce-block {
                    width: 60%;
                    margin: 0 auto;
                }
                .md\:pt-2 .ce-block__content {
                    max-width: 860px;
                    padding: 0 2rem;
                    margin: 0 !important;
                }

                .md\:pt-2 .ce-toolbar__content {
                    max-width: 60%;
                    margin-left: auto;
                }

                .cdx-settings-button[data-tune='withBorder'],
                .cdx-settings-button[data-tune='withBackground'],
                .cdx-settings-button[data-tune='stretched'] {
                    display: none;
                }

                .ce-toolbar__actions {
                    margin-right: 0;
                    padding-right: 0;
                    border-radius: 0.5em;
                    border: 1px solid #eee;
                    background-color: white;
                }

                .ce-toolbar__plus,
                .ce-toolbar__settings-btn {    
                    border-radius: 0.5rem;
                    padding: 0.4rem;
                }
            
                .ce-header {
                    font-weight: bold !important;
                }

                .cdx-quote-settings {
                    display: none;
                }

                .toggle-block__icon > svg {
                    display: inline-block;
                }
                .toggle-block__item {
                    margin-left: 0;
                }
                .toggle-block__selector {
                    border: 1px solid rgba(var(--colors-gray-300));
                    margin-bottom: 0.25rem;
                    border-radius: 0.25rem;
                    padding-left: 0.5rem;
                    margin-top: 0.5rem;
                }
                .toggle-block__item .ce-block__content .cdx-block {
                    border: 1px solid rgba(var(--colors-gray-300));
                    background-color: white;
                    padding-left: 1.75rem;
                    border-radius: 0.25rem;
                }
                .toggle-block__item + .toggle-block__item .ce-block__content .cdx-block {
                    border-top: none;
                    margin-top: -0.25rem;
                    padding-top: 0.25rem;
                }

                .editor-js h2 {
                    font-size: 30px;
                }

                .ce-toolbar__settings-btn {
                    width: 26px;
                    margin-left: 0px;
                }

                .cdxcarousel-list {
                    gap: 1rem;
                }

                .cdxcarousel-block {
                    width: 45%;
                    border: 1px solid rgba(var(--colors-gray-300));
                    flex: 1 0 auto;
                    border-radius: 0.5rem;
                }

                .cdxcarousel-caption {
                    margin: 5px;
                    width: auto;
                }

                .cdxcarousel-item img {
                    margin-bottom: 0px;
                }

                .cdxcarousel-item {
                    height: auto;
                    padding: 0;
                }
            </style>";
        });

        Nova::mainMenu(function (Request $request, Menu $menu) {
            return [
                MenuSection::dashboard(\App\Nova\Dashboards\Main::class)->icon(
                    "eye"
                ),
                MenuSection::make("Box office", [
                    MenuItem::resource(\App\Nova\Event::class)->withBadgeIf(
                        \App\Models\Event::unpublished()->count() . " new",
                        "info",
                        fn() => \App\Models\Event::unpublished()->count() > 0
                    ),
                    MenuItem::resource(\App\Nova\Strand::class),
                    MenuItem::resource(\App\Nova\Season::class),
                    MenuGroup::make("Programme", []),

                    MenuGroup::make("", [
                        MenuItem::resource(\App\Nova\Membership::class),
                        MenuItem::resource(\App\Nova\Fund::class),
                    ]),
                ])->icon("ticket"),
                MenuSection::resource(\App\Nova\Page::class)->icon(
                    "document-text"
                ),

                MenuSection::make("Journal", [
                    MenuItem::resource(\App\Nova\Post::class),
                    MenuItem::resource(\App\Nova\Tag::class),
                ])->icon("pencil"),

                // MenuSection::resource(\App\Nova\Post::class)->icon("pencil"),

                MenuSection::resource(\App\Nova\Product::class)->icon("gift"),

                MenuSection::resource(\App\Nova\Opportunity::class)->icon(
                    "briefcase"
                ),

                // (new \Outl1ne\PageManager\PageManager())->menu($request),
                MenuSection::make(__("novaMenuBuilder.sidebarTitle"))
                    ->path("/menus")
                    ->icon("collection"),

                (new \Outl1ne\NovaSettings\NovaSettings())
                    ->menu($request)
                    ->icon("cog"),

                MenuSection::resource(\App\Nova\User::class)->icon(
                    "user-group"
                ),

                (new \Spatie\BackupTool\BackupTool())->menu($request),

                MenuSection::make("Logs")->path("/logs"),
            ];
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
            return $user->enable_login;
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
            \Outl1ne\MenuBuilder\MenuBuilder::make(),
            new \Outl1ne\NovaSettings\NovaSettings(),
            new \Spatie\BackupTool\BackupTool(),
            \Laravel\Nova\LogViewer\LogViewer::make(),
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
