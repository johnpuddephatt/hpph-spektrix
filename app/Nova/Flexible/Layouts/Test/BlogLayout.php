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
use Laravel\Nova\Fields\Heading;

use Spatie\MediaLibrary\HasMedia;
use Jdp\Preview\Preview;
use Laravel\Nova\Fields\Tag;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Eminiarts\Tabs\Traits\HasTabs;

class BlogLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;
    use HasTabs;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "bloglayout";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Blog";

    /**
     * The view used to display a preview of this layout
     *
     * @var string
     */
    protected $view = "test.blog";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Heading::make("Content"),

            Text::make("Title"),
            Textarea::make("Subtitle"),
            Heading::make("Settings"),

            Number::make("Number of posts"),
        ];
    }

    /**
     * Additional data available to render in our view
     *
     * @return array
     */
    public function previewData($parameters)
    {
        return [
            "posts" => \App\Models\Post::select([
                "id",
                "title",
                "introduction",
                "created_at",
            ])
                ->take($parameters["number_of_posts"] ?? 3)
                ->get(),
        ];
    }
}
