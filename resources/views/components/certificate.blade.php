@props(['dark' => false, 'certificate'])

<div
    {{ $attributes->class(['inline-block min-w-[2em] text-center rounded-full align-middle px-1 type-xs-mono', 'bg-gray-dark text-white' => $dark, 'bg-gray' => !$dark]) }}>
    {{ $certificate }}
</div>
