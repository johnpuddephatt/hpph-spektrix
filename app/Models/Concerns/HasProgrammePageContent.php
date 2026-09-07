<?php

namespace App\Models\Concerns;

use App\Nova\Flexible\Layouts\ProgrammeIntroductionLayout;
use App\Nova\Flexible\Layouts\ProgrammeSliderLayout;
use App\Nova\Flexible\Layouts\TicketSubscriptionGroupLayout;
use Illuminate\Support\Str;
use Whitecube\NovaFlexibleContent\Layouts\Collection;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

/**
 * The body of a strand or season page is a list of content blocks.
 *
 * A new page is given the standard arrangement to start from, so an editor can
 * see and rearrange it straight away. That has to happen here rather than in
 * Nova, because strands and seasons are created by the Spektrix import, which
 * knows nothing about page content.
 *
 * A page that somehow has no blocks at all still renders the same arrangement,
 * which covers rows that predate the seeding.
 */
trait HasProgrammePageContent
{
    public static function bootHasProgrammePageContent(): void
    {
        static::created(fn ($model) => $model->seedContentBlocks());
    }

    /**
     * The blocks making up this page's body, in render order.
     */
    public function contentBlocks(): Collection
    {
        $content = $this->content;

        if ($content instanceof Collection && $content->isNotEmpty()) {
            return $content;
        }

        return new Collection(
            collect($this->defaultContentBlocks())
                ->map(fn ($layout) => $this->makeLayout($layout)->setModel($this))
                ->all()
        );
    }

    /**
     * Give a page the standard arrangement to start from. Does nothing to a
     * page that already has blocks, so it is safe to call more than once.
     */
    public function seedContentBlocks(): void
    {
        if ($this->hasStoredContentBlocks()) {
            return;
        }

        $this->content = json_encode(
            collect($this->defaultContentBlocks())
                ->map(fn ($layout) => [
                    'layout' => $this->makeLayout($layout)->name(),
                    'key' => Str::random(16),
                    'attributes' => new \stdClass(),
                ])
                ->all()
        );

        // Quietly: the row was only just written, so there is no cached
        // response for the observers to clear and nothing else to react to.
        $this->saveQuietly();
    }

    /**
     * Whether the stored content is a usable list of blocks. Content that is
     * not a list is the pre-flexible object shape, which flexible content
     * already discards as empty, so it counts as none.
     */
    protected function hasStoredContentBlocks(): bool
    {
        $blocks = json_decode($this->getRawOriginal('content') ?? '', true);

        return is_array($blocks) && $blocks !== [] && array_is_list($blocks);
    }

    /**
     * Passing an empty field list keeps Nova's field classes out of front-end
     * requests: only the layout's name and its parent model matter here.
     */
    protected function makeLayout(string $layout): Layout
    {
        return new $layout(null, null, []);
    }

    /**
     * The arrangement a page starts with, and falls back to when it has none.
     */
    protected function defaultContentBlocks(): array
    {
        return [
            ProgrammeIntroductionLayout::class,
            TicketSubscriptionGroupLayout::class,
            ProgrammeSliderLayout::class,
        ];
    }
}
