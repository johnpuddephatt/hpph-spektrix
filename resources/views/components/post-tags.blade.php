@if (count($tags))
    {{ $tags[0]->name }}
    @if (count($tags) > 1)
        /
        {{ $tags[1]->name }}
    @endif
@endif
