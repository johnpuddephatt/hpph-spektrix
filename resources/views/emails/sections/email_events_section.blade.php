@php
$array = Arr::pluck($section->events, 'attributes.event');

$films = \App\Models\Event::withoutGlobalScopes()
    ->whereIn('id', $array)
    ->orderByRaw('FIELD(id, "' . implode('","', $array) . '")')
    ->with([
        'instances' => function (\Illuminate\Contracts\Database\Eloquent\Builder $query) use ($email) {
            $query->where('start', '>=', $email->date)->where('start', '<=', $email->date->copy()->addDays(7));
        },
    ])
    ->get()
    ->each(function ($event, $key) use ($section) {
        if ($section->events[$key]->attributes->replacement_description ?: false) {
            $event->description = $section->events[$key]->attributes->replacement_description;
        }
    });

@endphp

<mj-wrapper background-color="#e6e4dd" full-width="full-width">
    @if ($section->title)
        <mj-section padding="25px 10px 0px">
            <mj-text font-size="24px" line-height="1.2" font-weight="700">{{ $section->title }}</mj-text>
        </mj-section>
    @endif
    @if ($section->layout === 'rows')
        @include('emails.components.film_rows')
    @else
        @include('emails.components.film_columns')
    @endif
</mj-wrapper>
