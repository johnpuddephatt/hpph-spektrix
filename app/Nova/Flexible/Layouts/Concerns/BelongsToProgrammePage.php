<?php

namespace App\Nova\Flexible\Layouts\Concerns;

use App\Models\Season;

/**
 * Shared behaviour for the blocks that make up the body of a strand or season
 * page. Whitecube hands every layout its parent model during casting (see
 * HasFlexible::createMappedLayout), so these blocks need nothing from the
 * editor and nothing from the controller — they read the strand or season
 * they were rendered on.
 *
 * $this->model is the protected property Whitecube sets; it is exposed as
 * `subject` so Blade can reach it, since a protected property would otherwise
 * fall through to getAttribute().
 */
trait BelongsToProgrammePage
{
    /**
     * The strand or season this block belongs to.
     */
    public function getSubjectAttribute()
    {
        return $this->model;
    }

    /**
     * The argument the slider queries expect: 'strand' or 'season'.
     */
    public function getSubjectTypeAttribute(): string
    {
        return $this->model instanceof Season ? 'season' : 'strand';
    }

    /**
     * The page's accent, used for the introduction band and section headings.
     *
     * Null is meaningful and common: most strands have no colour set, and
     * seasons have no colour column at all. Callers must leave the inline
     * style off entirely in that case, so the band falls back to `bg-yellow`
     * and headings keep inheriting their section's text colour.
     */
    public function getAccentColorAttribute(): ?string
    {
        return $this->model?->color;
    }

    /**
     * The accent passed down to the cards inside the what's on slider.
     *
     * The season page has always passed the cards a slightly duller yellow of
     * its own; strands pass their colour, null included.
     */
    public function getSliderColorAttribute(): ?string
    {
        return $this->subject_type === 'season' ? '#f2d13c' : $this->model?->color;
    }
}
