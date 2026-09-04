<?php namespace App\Nova\Flexible\Layouts;

use Advoor\NovaEditorJs\NovaEditorJsCast;
use App\Nova\Flexible\Layouts\Concerns\AppearsInPageMenu;
use App\Nova\Flexible\Layouts\Concerns\HasPageMenuEntry;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\File;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class MembershipComparisonLayout extends Layout implements HasPageMenuEntry
{
    use AppearsInPageMenu;

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
                            File::make("Video")->acceptedTypes("video/*"),

        ];
    }

    public function menuLabel(): ?string
    {
        // This block has no heading of its own to borrow a label from.
        return "Memberships";
    }

    public function getMembershipsAttribute()
    {
        return $this->flexible("memberships", [
            "membership" => \App\Nova\Flexible\Layouts\MembershipLayout::class,
        ]);
    }
}
