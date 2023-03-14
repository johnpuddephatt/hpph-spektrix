<?php namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsCast;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class FeaturedMembershipLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "featured-membership";

    protected $casts = [];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Featured membership";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make("Video")->acceptedTypes("video/*"),
            Text::make("Title"),
            Text::make("Subtitle"),
            Select::make("Membership", "membership_id")
                ->options(\App\Models\Membership::pluck("name", "id"))
                ->searchable()
                ->displayUsingLabels(),
        ];
    }

    public function getMembershipAttribute()
    {
        return \App\Models\Membership::find($this->membership_id);
    }
}
