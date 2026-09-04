<?php

namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsField;
use App\Nova\Flexible\Layouts\Concerns\AppearsInPageMenu;
use App\Nova\Flexible\Layouts\Concerns\HasPageMenuEntry;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Whitecube\NovaFlexibleContent\Flexible;

class FaqsLayout extends Layout implements HasPageMenuEntry
{
    use AppearsInPageMenu;

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

    public function menuLabel(): ?string
    {
        // The block's own heading is longer than a menu wants
        // ("Information & FAQs"), so the menu just says FAQs.
        return "FAQs";
    }

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
