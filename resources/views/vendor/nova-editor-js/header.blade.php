<div class="container mt-12 max-w-6xl">
    <{{ "h{$level}" }} class="{{ match ($level) {2 => 'type-h5',3 => 'type-subtitle'} }} mb-5 max-w-2xl">
        {{ $text }}
        </{{ "h{$level}" }}>
</div>
