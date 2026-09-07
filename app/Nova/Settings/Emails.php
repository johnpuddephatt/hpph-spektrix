<?php

namespace App\Nova\Settings;

use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Outl1ne\NovaSimpleRepeatable\SimpleRepeatable;

class Emails
{
    public $page = 'Email newsletters';

    public function fields(): array
    {
        return [

            SimpleRepeatable::make('FAQs', 'email_faqs', [
                Textarea::make('Question'),
                Trix::make('Answer'),
            ])->addRowLabel('Add new FAQ'),
        ];
    }

    public function casts(): array
    {
        return [
            'email_faqs' => 'array',
        ];
    }
}
