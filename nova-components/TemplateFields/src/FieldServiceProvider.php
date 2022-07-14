<?php

namespace Hpph\TemplateFields;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public $fields = ["heading", "basic-header", "banner"];

    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            foreach ($this->fields as $field) {
                Nova::script(
                    "$field-field",
                    __DIR__ . "/../dist/$field/field.js"
                );
                Nova::style(
                    "$field-field",
                    __DIR__ . "/../dist/$field/field.css"
                );
            }
        });
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
