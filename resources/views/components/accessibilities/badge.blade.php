@props(['title' => ''])

<abbr title="{{ $title }}"
    {{ $attributes->class('bg-black rounded text-white font-bold text-xs uppercase inline-block no-underline px-2.5 py-0.5 text-center cursor-default z-[2]') }}>
    {{ $slot }}</abbr>
