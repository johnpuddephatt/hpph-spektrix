<?php

namespace App\Nova\MenuBuilderTypes;

use Outl1ne\MenuBuilder\MenuItemTypes\MenuItemSelectType;
use Laravel\Nova\Fields\Select;

class PageType extends MenuItemSelectType
{
    /**
     * Get menu link name shown in CMS when selecting link type.
     * ie ('Product Link' or 'Image Link').
     *
     * @return string
     **/
    public static function getName(): string
    {
        return "Page";
    }

    public static function getIdentifier(): string
    {
        return "page";
    }

    /**
     * Get list of options shown in a select dropdown.
     *
     * Should be a map of [key => value, ...], where key is a unique identifier
     * and value is the displayed string.
     *
     * @return array
     **/
    public static function getOptions($locale): array
    {
        return \App\Models\Page::orderPagesByUrl()
            ->get()
            ->pluck("name", "id")
            ->toArray();
    }

    /**
     * Get the subtitle value shown in CMS menu items list.
     *
     * @param null $value
     * @param array|null $data The data from item fields.
     * @param $locale
     * @return string
     */
    public static function getDisplayValue($value, ?array $data, $locale)
    {
        return "Page: " . \App\Models\Page::find($value)->name;
    }

    /**
     * Get the value of the link visible to the front-end.
     *
     * Can be anything. It is up to you how you will handle parsing it.
     *
     * This will only be called when using the nova_get_menu()
     * and nova_get_menus() helpers or when you call formatForAPI()
     * on the Menu model.
     *
     * @param null $value The key from options list that was selected.
     * @param array|null $data The data from item fields.
     * @param $locale
     * @return any
     */
    public static function getValue($value, ?array $data, $locale)
    {
        return \App\Models\Page::find($value)->URL;
    }

    public static function getFields(): array
    {
        return [
                // Select::make("Value")->options(
                //     \App\Models\Page::all()
                //         ->pluck("title", "id")
                //         ->toArray()
                // ),
            ];
    }

    /**
     * Get the rules for the resource.
     *
     * @return array A key-value map of attributes and rules.
     */

    public static function getRules(): array
    {
        return [
                // "value" => "required",
            ];
    }

    public static function getData($data = null)
    {
        return $data;
    }
}
