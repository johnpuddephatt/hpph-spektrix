<?php

namespace App\Nova\Settings;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Outl1ne\NovaSimpleRepeatable\SimpleRepeatable;
use Trin4ik\NovaSwitcher\NovaSwitcher;

class Emails
{
    public $page = "Email newsletters";

    public function fields(): array
    {
        return [

            SimpleRepeatable::make("FAQs", "email_faqs", [
                Textarea::make("Question"),
                Trix::make("Answer"),
            ])->addRowLabel("Add new FAQ"),
        ];
    }

    public function casts(): array
    {
        return [
            "email_faqs" => "array",
        ];
    }
}
