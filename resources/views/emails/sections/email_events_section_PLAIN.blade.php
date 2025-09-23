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

@if ($section->title)
{!! $section->title !!}
@endif

@foreach ($films as $film)

{{ $film->name }} @if($film->certificate_age_guidance)({{ $film->certificate_age_guidance }})@endif
@if ($film->audio_description)
[Audio Described] 
@endif
@if ($film->strand && $film->strand->name !== 'Bring Your Own Baby')
 [Part of {!! $film->strand->name !!}]
@endif

@if ($section->display_times == 'range' && $film->date_range)
{!! Str::of($film->date_range)->upper()->replace('&MIDDOT;', '&middot;') !!}

@endif
{!! Str::of($film->description)->stripTags() !!}

@if($film->instances->count())
@foreach ($film->instances as $instance)
{{ $instance->start->format('D d M') }}: {{ $instance->start->format('H:i') }} @if ($instance->special_event){{ $instance->special_event }} @endif @if ($instance->captioned)[Captioned] @endif @if ($instance->autism_friendly)[Autism friendly] @endif @if ($instance->toddler_friendly)[Toddler friendly] @endif @if ($instance->strand_name == 'Bring Your Own Baby')[Bring Your Own Baby] @endif 
@endforeach

@endif
{{ $film->url }}


@endforeach

