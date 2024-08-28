{{-- prettier-ignore-start --}}

@if ($film->show_times_on_separate_rows)
    @foreach ($film->instances as $instance)
        <strong>{{ $instance->start->format('D d M') }}</strong>:
        @include('emails.components.instance_time')
        <br>
    @endforeach
@else
    @php
        $grouped = $film->instances->groupBy(function ($instance) {
            return $instance->start->format('D d M');
        });
    @endphp

    @foreach ($grouped as $date => $instances)
        <strong>{{ $date }}:</strong>
        @foreach ($instances as $instance)
            {!! rtrim(view('emails.components.instance_time', ['instance' => $instance])->render()) !!}@if (!$loop->last)<span>, </span>
            @else
                <br>
            @endif
        @endforeach
    @endforeach

@endif
{{-- prettier-ignore-end --}}
