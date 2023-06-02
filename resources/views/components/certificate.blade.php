@props(['dark' => false, 'certificate'])

<div
    {{ $attributes->class(['inline-block min-w-[2em] text-center rounded-full align-middle px-1 type-xs-mono text-white', 'bg-gray-dark' => $dark, 'bg-black' => !$dark]) }}>
    {{ $certificate }}
</div>
