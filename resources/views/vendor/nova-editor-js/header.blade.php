<div class="container mt-12 max-w-6xl">
    <{{ "h{$level}" }} class="{{ match ($level) {2 => 'type-medium',3 => 'type-regular'} }} mb-5 max-w-2xl">
        {{ $text }}
        </{{ "h{$level}" }}>
</div>
