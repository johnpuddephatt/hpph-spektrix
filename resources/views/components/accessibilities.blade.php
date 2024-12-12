@props(['captioned' => false, 'signedbsl' => false, 'audiodescribed' => false, 'autism_friendly' => false, 'toddler_friendly' => false])

<div {{ $attributes->class(['flex flex-row gap-0.5']) }}>

    @if ($captioned)
        <x-accessibilities.badge title="Captioned screening">Captioned</x-accessibilities.badge>
    @endif
    @if ($signedbsl)
        <x-accessibilities.badge title="Signed BSL">BSL</x-accessibilities.badge>
    @endif
    @if ($audiodescribed)
        <x-accessibilities.badge title="Audio described">AD</x-accessibilities.badge>
    @endif
    @if ($autism_friendly)
        <x-accessibilities.badge title="Autism-friendly screening">Autism</x-accessibilities.badge>
    @endif
        @if ($toddler_friendly)
        <x-accessibilities.badge title="Toddler-friendly screening">Toddler</x-accessibilities.badge>
    @endif
</div>
