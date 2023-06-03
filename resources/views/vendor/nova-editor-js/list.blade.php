{!! $style == 'unordered'
    ? '<ul class="list-disc marker:text-yellow ml-4 ">'
    : '<ol class="list-decimal  ml-6 marker:type-xs-mono">' !!}
@foreach ($items as $item)
    <li class="mb-2 max-w-[50ch]">
        {!! $item !!}
    </li>
@endforeach
{!! $style == 'unordered' ? '</ul>' : '</ol>' !!}
