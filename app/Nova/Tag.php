<?php
namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Spatie\Tags\Tag as TagModel;

class Tag extends Resource
{
    public static $model = TagModel::class;

    public static $title = "name";

    public static $search = ["name"];

    public function fields(Request $request)
    {
        return [Text::make("Name")->sortable()];
    }
}
