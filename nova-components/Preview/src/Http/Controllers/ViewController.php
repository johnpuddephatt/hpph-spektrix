<?php

namespace Jdp\Preview\Http\Controllers;

use Laravel\Nova\Http\Requests\ActionRequest as NovaActionRequest;
use Laravel\Nova\Http\Controllers\ActionController as NovaActionController;

class ViewController extends NovaActionController
{
    public function __invoke(NovaActionRequest $request)
    {
        return view($request->_view, $request->all());
    }
}
