<?php

namespace App\Nova\Flexible\Layouts;

use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class SignupFormLayout extends Layout
{
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'signup-form';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Signup form';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Form', 'signup_form_id')
                ->options(
                    static::cachedOptions(
                        'signup_forms',
                        fn () => \App\Models\SignupForm::pluck('name', 'id')
                    )
                )
                ->searchable()
                ->help(
                    'Which set of options to offer. Manage these under Signup forms.'
                ),
        ];
    }

    public function getFormAttribute()
    {
        return \App\Models\SignupForm::find($this->signup_form_id);
    }
}
