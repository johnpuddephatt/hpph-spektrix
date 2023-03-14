<?php namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsCast;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class MembershipLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "membership";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Membership";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make("Membership", "membership_name")
                ->options(\App\Models\Membership::pluck("name", "id"))
                ->searchable(),
        ];
    }

    public function getMembershipAttribute($value)
    {
        return \App\Models\Membership::find($this->membership_name);
    }
}
