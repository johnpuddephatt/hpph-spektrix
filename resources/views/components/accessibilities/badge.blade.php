@props(['dark' => false, 'title' => '', 'abbreviation' => '', 'class' => ''])

<abbr title="{{ $dark ? $title : null }}" @class([
    'bg-gray-dark rounded-full text-white' => $dark,
    'rounded bg-sand-light' => !$dark,
    $class,
    'type-xs-mono',
    'block',
    'no-underline',
    'px-2',
    'text-center',
    'pointer-default',
    'z-10',
])>
    {{ $dark ? $slot : $title }}</abbr>
