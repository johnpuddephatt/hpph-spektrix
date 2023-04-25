@if ($slot)
    <span
        {{ $attributes->merge(['class' => 'type-xs py-0.5 text-black uppercase inline-block rounded px-2 bg-sand-light !font-bold !no-underline']) }}>With
        {{ $slot }}</span>
@endif
