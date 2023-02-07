@props(['dark' => false, 'certificate'])

<div
    {{ $attributes->class(['inline-block min-w-[2em] text-center rounded-full !leading-tight  pt-0.5 px-1.5 type-xs-mono', 'bg-gray-dark text-white' => $dark, 'bg-gray' => !$dark]) }}>
    {{ $certificate }}
</div>
