<?php

namespace App\Nova\Flexible\Layouts\Concerns;

/**
 * Implemented by the flexible layouts that can be listed in a page's
 * "on this page" menu (see the display_menu setting on Page). Blocks that are
 * decoration rather than a section of the page — images, quotes — deliberately
 * don't implement this.
 */
interface HasPageMenuEntry
{
    /**
     * The wording used for this block in the menu, or null when the block
     * shouldn't be listed (usually because it has nothing to label it with).
     */
    public function menuLabel(): ?string;

    /**
     * The id of the element the menu entry links to. The block's own Blade
     * partial has to render this as an id, or the link goes nowhere.
     */
    public function menuAnchor(): string;
}
