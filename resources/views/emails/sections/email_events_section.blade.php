@php
$array = Arr::pluck($section->events, 'attributes.event');

$films = \App\Models\Event::withoutGlobalScopes()
    ->whereIn('id', $array)
    ->orderByRaw('FIELD(id, "' . implode('","', $array) . '")')
    ->with([
        'instances' => function (\Illuminate\Contracts\Database\Eloquent\Builder $query) use ($email, $section) {
            if (!$section->include_all_dates) {
                $query->where('start', '>=', $email->date)->where('start', '<=', $email->date->copy()->addDays(7));
            }
        },
    ])
    ->get()
    ->each(function ($event, $key) use ($section) {
        if ($section->events[$key]->attributes->replacement_description ?: false) {
            $event->description = $section->events[$key]->attributes->replacement_description;
        }

        if ($section->events[$key]->attributes->show_times_on_separate_rows ?: false) {
            $event->show_times_on_separate_rows = $section->events[$key]->attributes->show_times_on_separate_rows;
        }
    });

@endphp

<mj-wrapper background-color="#e6e4dd" full-width="full-width">
    @if ($section->title)
        <mj-section padding="25px 10px 0px">
            @include('emails.components.heading', ['heading' => $section->title])
        </mj-section>
    @endif
    @if ($section->layout === 'rows')
        @include('emails.components.film_rows')
    @else
        @include('emails.components.film_columns')
    @endif
</mj-wrapper>
