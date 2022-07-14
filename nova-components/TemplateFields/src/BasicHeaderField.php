<?php

namespace Hpph\TemplateFields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class BasicHeaderField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = "basic-header-field";

    protected function fillAttributeFromRequest(
        NovaRequest $request,
        $requestAttribute,
        $model,
        $attribute
    ) {
        if ($request->exists($requestAttribute)) {
            \Laravel\Nova\Http\Requests\NovaRequest::createFrom($request)
                ->findModelQuery()
                ->first()
                ->addFromMediaLibraryRequest(
                    json_decode($request->$requestAttribute, true)
                )
                ->toMediaCollection($requestAttribute);

            $model->{$attribute} = json_decode(
                $request[$requestAttribute],
                true
            );
        }
    }
}
