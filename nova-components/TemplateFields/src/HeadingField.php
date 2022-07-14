<?php

namespace Hpph\TemplateFields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class HeadingField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = "heading-field";
}
