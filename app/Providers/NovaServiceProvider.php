<?php

namespace App\Providers;

use App\Nova\AccessTag;
use App\Nova\Dashboards\Main;
use App\Nova\Email;
use App\Nova\Event;
use App\Nova\Fund;
use App\Nova\Membership;
use App\Nova\Opportunity;
use App\Nova\Page;
use App\Nova\Post;
use App\Nova\Product;
use App\Nova\Season;
use App\Nova\Settings\Alert;
use App\Nova\Settings\Banner;
use App\Nova\Settings\Contact;
use App\Nova\Settings\Emails;
use App\Nova\Settings\Messages;
use App\Nova\Settings\Newsletter;
use App\Nova\Settings\Redirects;
use App\Nova\Settings\System;
use App\Nova\SignupForm;
use App\Nova\Strand;
use App\Nova\Tag;
use App\Nova\TicketSubscription;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Laravel\Nova\LogViewer\LogViewer;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Outl1ne\MenuBuilder\MenuBuilder;
use Outl1ne\NovaSettings\NovaSettings;
use Spatie\BackupTool\BackupTool;

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
            new Redirects,
            new Alert,
            new Banner,
            new Contact,
            new Messages,
            new Emails,
            new System,
            new Newsletter,
        ];

        foreach ($settings as $setting) {
            NovaSettings::addSettingsFields(
                $setting->fields() ?? [],
                $setting->casts() ?? [],
                $setting->page ?? null
            );
        }

        Nova::serving(function () {
            Nova::script(
                'editorjs-plugins',
                // Vite::asset("resources/js/editorjs-plugins.js")
                public_path('editorjs-plugins.js')
            );
        });

        Nova::footer(function ($request) {
            return "
            <style>

                .\!h-10 { height: 2.5rem !important; }
                html:not(.dark) [data-testid='content'] > div:nth-of-type(1) { padding-bottom: 6rem; min-height: 100%; background-image: linear-gradient(to bottom, rgb(220,230,240), transparent);}
                #nova { position: relative;}
                header {box-shadow: rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.1) 0px 1px 2px -1px}

                .trix-button-group--block-tools,
                .trix-button-group--file-tools, 
                .trix-button-group--history-tools 
                 {
                    display: none !important;
                }

                trix-editor {
                    border-color: rgb(203,213,225);
                }

                .editor-js, #editor-js-content {
                    padding-top: 0.5rem;
                    padding-bottom: 10rem;
                    margin-bottom: 4rem;
                    border-radius: 0.5rem;
                    box-shadow: none;
                    border: 1px solid rgb(203,213,225);
                    // width: 73.75%;
                    width: 100%;
                }
                .ce-toolbar__content,
                .ce-block__content {
                    margin-left: 0;
                }

                .ce-toolbar__actions {
                    margin-right: 2rem !important;
                }

                .md\:flex-col  > .editor-js, .md\:flex-col  > #editor-js-content {
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
                    font-size: 1rem;
                    line-height: 1.5;
                }
                .md\:flex-col .ce-block {
                    width: 60%;
                    margin: 0 auto;
                }
                .md\:flex-col .ce-block__content {
                    max-width: 860px;
                    padding: 0 2rem;
                    margin: 0 !important;
                }

                .md\:flex-col .ce-toolbar__content {
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

                :has(> * > * > * > * > [dusk='toggle-layouts-dropdown-or-add-default']):not(.overflow-y-scroll) {
                    
                    overflow: visible !important;
                }
}
            </style>";
        });

        Nova::mainMenu(function (Request $request, Menu $menu) {
            return [
                MenuSection::dashboard(Main::class)->icon(
                    'eye'
                ),
                MenuSection::make('Box office', [
                    MenuItem::resource(Event::class)->withBadgeIf(
                        \App\Models\Event::unpublished()->count().' new',
                        'info',
                        fn () => \App\Models\Event::unpublished()->count() > 0
                    ),
                    MenuItem::resource(Strand::class),
                    MenuItem::resource(Season::class),
                    MenuItem::resource(AccessTag::class),
                    MenuGroup::make('Programme', []),

                    MenuGroup::make('', [
                        MenuItem::resource(Membership::class),
                        MenuItem::resource(Fund::class),
                        MenuItem::resource(TicketSubscription::class),

                    ]),
                ])->icon('ticket'),
                MenuSection::resource(Page::class)->icon(
                    'document-text'
                ),

                MenuSection::make('Journal', [
                    MenuItem::resource(Post::class),
                    MenuItem::resource(Tag::class),
                ])->icon('pencil'),

                // MenuSection::resource(\App\Nova\Post::class)->icon("pencil"),

                MenuSection::resource(Product::class)->icon('gift'),

                MenuSection::resource(Opportunity::class)->icon(
                    'briefcase'
                ),

                MenuSection::resource(Email::class)->icon(
                    'at-symbol'
                ),

                MenuSection::resource(SignupForm::class)->icon(
                    'clipboard-list'
                ),

                // (new \Outl1ne\PageManager\PageManager())->menu($request),
                MenuSection::make(__('novaMenuBuilder.sidebarTitle'))
                    ->path('/menus')
                    ->icon('collection'),

                (new NovaSettings)
                    ->menu($request)
                    ->icon('cog'),

                MenuSection::resource(User::class)->icon(
                    'user-group'
                ),

                (new BackupTool)->menu($request),

                MenuSection::make('Logs')->path('/logs'),
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
        Gate::define('viewNova', function ($user) {
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
        return [new Main];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            MenuBuilder::make(),
            new NovaSettings,
            new BackupTool,
            LogViewer::make(),
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
