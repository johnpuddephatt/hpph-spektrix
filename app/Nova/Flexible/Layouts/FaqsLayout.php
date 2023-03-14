<?php

namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsField;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Whitecube\NovaFlexibleContent\Flexible;

class FaqsLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "faqs";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Frequently asked questions";

    public function getFaqsAttribute()
    {
        return $this->flexible("faqs", [
            "single-faq" => \App\Nova\Flexible\Layouts\SingleFaqLayout::class,
        ]);
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make("Title", "title")
                ->default("Information & FAQs")
                ->hideFromIndex(),

            Flexible::make("FAQs", "faqs")
                ->addLayout(\App\Nova\Flexible\Layouts\SingleFaqLayout::class)
                ->button("Add a question"),
        ];
    }
}
