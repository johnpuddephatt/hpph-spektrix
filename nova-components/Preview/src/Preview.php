<?php

namespace Jdp\Preview;

use Laravel\Nova\Fields\Field;
use Illuminate\Support\Facades\Vite;

class Preview extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = "preview";

    public function fields(array $fields)
    {
        foreach ($fields as $field) {
            if (method_exists($field, "stacked")) {
                $field->stacked(true);
            }
        }

        return $this->withMeta(["fields" => $fields]);
    }

    public function view(string $view)
    {
        return $this->withMeta(["view" => $view]);
    }

    public function withStylesheet($stylesheet = "resources/css/app.css")
    {
        return $this->withMeta(["stylesheet" => Vite::asset($stylesheet)]);
    }
}
