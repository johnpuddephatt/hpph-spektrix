<{{ "h{$level}" }}
    class="{{ match ($level) {2 => 'type-medium',3 => 'type-regular',default => 'type-small'} }} mt-12 mb-8 max-w-[39ch]">
    {!! $text !!}
    </{{ "h{$level}" }}>
