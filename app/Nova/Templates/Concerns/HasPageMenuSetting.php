<?php

namespace App\Nova\Templates\Concerns;

use Laravel\Nova\Fields\Boolean;

trait HasPageMenuSetting
{
    protected function pageMenuField(): Boolean
    {
        return Boolean::make('Display menu?', 'display_menu')->help(
            'Shows an "on this page" menu below the page header, linking to each section of the page that can be labelled. Text sections are labelled with their own title, so a section with no title is not listed.'
        );
    }
}
