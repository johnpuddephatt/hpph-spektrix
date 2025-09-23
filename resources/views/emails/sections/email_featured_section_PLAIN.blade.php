@php

    $film = \App\Models\Event::withoutGlobalScopes()

        ->with([
            'instances' => function (\Illuminate\Contracts\Database\Eloquent\Builder $query) use ($email, $section) {
                if (!$section->include_all_dates) {
                    $query->where('start', '>=', $email->date)->where('start', '<=', $email->date->copy()->addDays(7));
                }
            },
        ])
        ->find($section->event);

@endphp


{{ $film->name }}
{!! Str::of($film->description)->stripTags() !!}
{{ $film->url }}


