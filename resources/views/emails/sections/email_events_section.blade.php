{{ 'FIELD(id,' . implode(',', $section->films) . ')' }}

@php
$films = \App\Models\Event::withoutGlobalScopes()
    ->whereIn('id', $section->films)
    ->orderByRaw('FIELD(id, "' . implode('","', $section->films) . '")')
    ->get();
@endphp

@foreach ($films->chunk(3) as $chunk)
    @foreach ($chunk as $film)
        @if ($section->direction === 'horizontal')
            @include('emails.components.film_horizontal', ['film' => $film])
        @else
            @include('emails.components.film_vertical', ['film' => $film])
        @endif
    @endforeach
    </mj-section>
@endforeach
