@props(['title' => ''])

<abbr title="{{ $title }}" @class([
    'bg-gray-dark',
    'rounded-full',
    'text-white'   
    'type-xs-mono',
    'block',
    'no-underline',
    'px-2',
    'text-center',
    'cursor-default',
    'z-[2]',
])>
    {{ $slot }}</abbr>
