{{ 'FIELD(id,' . implode(',', $section->films) . ')' }}

@php
$films = \App\Models\Event::withoutGlobalScopes()
    ->whereIn('id', $section->films)
    ->orderByRaw('FIELD(id, "' . implode('","', $section->films) . '")')
    ->get();
@endphp

@if ($section->layout === 'rows')
    @include('emails.components.film_rows')
@else
    @include('emails.components.film_columns')
@endif
