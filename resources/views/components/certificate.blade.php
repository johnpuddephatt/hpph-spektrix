@props(['dark' => false, 'certificate'])

<div
    {{ $attributes->class(['inline-block rounded pt-0.5 px-2 font-mono', 'bg-gray-dark text-white' => $dark, 'bg-gray' => !$dark]) }}>
    {{ $certificate }}
</div>
