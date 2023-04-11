{!! $style == 'unordered'
    ? '<ul class="list-disc marker:text-yellow ml-4 max-w-2xl">'
    : '<ol class="list-decimal  ml-6 marker:type-xs-mono max-w-2xl">' !!}
@foreach ($items as $item)
    <li class="mb-2">
        {!! $item !!}
    </li>
@endforeach
{!! $style == 'unordered' ? '</ul>' : '</ol>' !!}
