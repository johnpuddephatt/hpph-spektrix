@php
$array = Arr::pluck($section->events, 'attributes.event');

$films = \App\Models\Event::withoutGlobalScopes()
    ->whereIn('id', $array)
    ->orderByRaw('FIELD(id, "' . implode('","', $array) . '")')
    ->get();
@endphp

@if ($section->layout === 'rows')
    @include('emails.components.film_rows')
@else
    @include('emails.components.film_columns')
@endif
