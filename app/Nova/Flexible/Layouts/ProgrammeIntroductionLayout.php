<?php

namespace App\Nova\Flexible\Layouts;

use App\Nova\Flexible\Layouts\Concerns\BelongsToProgrammePage;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Trix;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class ProgrammeIntroductionLayout extends Layout
{
    use BelongsToProgrammePage;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'programme-introduction';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Introduction';

    /**
     * Get the fields displayed by the layout.
     *
     * The name and description still come from the strand or season itself,
     * because the cards and menus elsewhere on the site read them too. The
     * additional description and funders logo are only ever shown here, so
     * they belong to the block.
     */
    public function fields()
    {
        return [
            Heading::make(
                'The heading and description shown here are the ones entered on this '.
                    'strand or season, since the cards elsewhere on the site use them too.'
            )->asHtml(),

            Trix::make('Additional description'),

            Image::make('Funders logo', 'funders_logo')
                ->disableDownload()
                ->preview(function ($value, $disk) {
                    return $value ? Storage::disk($disk)->url($value) : null;
                })
                ->help(
                    'Logos should have a transparent background and be in PNG format. '.
                        'Individual logos should be approximately 300-400px wide. Multiple logos '.
                        'can be artworked onto a single canvas 600-800px wide.'
                ),
        ];
    }
}
