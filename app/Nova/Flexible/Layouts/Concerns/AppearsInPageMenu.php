<?php

namespace App\Nova\Flexible\Layouts\Concerns;

use Illuminate\Support\Str;

/**
 * Default page-menu behaviour for a flexible layout: the label is the block's
 * own title. Layouts whose type implies a name — a FAQs block is always
 * "FAQs" — override menuLabel() instead.
 *
 * Note that the layout's attributes have to be read with getAttribute():
 * $this->title inside the class is the layout's *display* title ("Text"),
 * not the title the editor typed.
 */
trait AppearsInPageMenu
{
    public function menuLabel(): ?string
    {
        $title = $this->getAttribute('title');

        return filled($title) ? (string) $title : null;
    }

    public function menuAnchor(): string
    {
        // Layouts with their own Slug field (text sections) keep using it, so
        // that links written before the menu existed still resolve.
        return $this->getAttribute('slug')
            ?: (Str::slug($this->menuLabel() ?? '') ?: $this->key());
    }
}
