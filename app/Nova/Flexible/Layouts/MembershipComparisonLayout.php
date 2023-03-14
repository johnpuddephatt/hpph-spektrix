<?php namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsCast;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class MembershipComparisonLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "membership-comparison";

    protected $casts = [];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Membership comparison";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Flexible::make("Memberships", "memberships")
                ->addLayout(\App\Nova\Flexible\Layouts\MembershipLayout::class)
                ->button("Add membership"),
        ];
    }

    public function getMembershipsAttribute()
    {
        return $this->flexible("memberships", [
            "membership" => \App\Nova\Flexible\Layouts\MembershipLayout::class,
        ]);
    }
}
