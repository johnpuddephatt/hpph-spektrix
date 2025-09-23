@php
$pick = \App\Models\Post::withoutGlobalScopes()->find($section->pick);
@endphp

@if ($pick)
This week’s Hyde Park Pick

{{ Str::of($pick->title)->replace('Hyde Park Pick… ', '')->replace('Hyde Park Pick: ', '') }}

{!! $pick->introduction !!}

{{ $pick->url }}



@endif
