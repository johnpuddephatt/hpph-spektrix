<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SignupForm extends Model
{
    protected $fillable = [
        'name',
        'heading',
        'intro',
        'success_message',
        'tags',
        'statements',
    ];

    protected $casts = [
        'tags' => 'array',
        'statements' => 'array',
    ];

    /**
     * The tags this form offers, in the order the editor arranged them, grouped
     * for display under their Spektrix tag group name.
     *
     * Reads through the models' enabled scope, so a tag Spektrix has stopped
     * publishing drops out of the form without the selection being lost.
     */
    public function tagsByGroup(): Collection
    {
        return $this->selectedTags()
            ->load('group')
            ->groupBy(fn (SpektrixTag $tag) => $tag->group?->name ?? '');
    }

    public function selectedTags(): Collection
    {
        return $this->orderBySelection(
            SpektrixTag::whereIn('id', $this->tags ?? [])->get(),
            $this->tags ?? []
        );
    }

    public function selectedStatements(): Collection
    {
        return $this->orderBySelection(
            SpektrixStatement::whereIn('id', $this->statements ?? [])->get(),
            $this->statements ?? []
        );
    }

    /**
     * Restore the editor's ordering, which whereIn() does not preserve.
     */
    protected function orderBySelection(Collection $models, array $ids): Collection
    {
        return $models
            ->sortBy(fn (Model $model) => array_search($model->getKey(), $ids))
            ->values();
    }
}
