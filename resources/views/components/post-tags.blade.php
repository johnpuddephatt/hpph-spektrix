@props(['class' => null, 'tags'])

@if ($tags)
    <div class="{{ $class }}">
        {{ $tags[0]->name_translated }}
        @if (count($tags) > 1)
            /
            {{ $tags[1]->name_translated }}
        @endif
    </div>
@endif
