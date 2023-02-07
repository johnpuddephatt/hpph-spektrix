<?php

namespace App\Nova\Flexible\Layouts\Test;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Textarea;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Image;

use Spatie\MediaLibrary\HasMedia;
use Jdp\Preview\Preview;
use Laravel\Nova\Fields\Tag;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Eminiarts\Tabs\Traits\HasTabs;

class HeroLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;
    use HasTabs;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "herolayout";

    protected $view = "test.hero";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Hero";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Image::make("Image")->disk("public"),
            Text::make("Title"),
            Textarea::make("Subtitle"),
            NovaSwitcher::make("Enabled"),
        ];
    }
}
