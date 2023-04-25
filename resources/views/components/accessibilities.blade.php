@props(['captioned' => false, 'signedbsl' => false, 'audiodescribed' => false, 'relaxed' => false])

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
    @if ($relaxed)
        <x-accessibilities.badge title="Relaxed screening">Relaxed</x-accessibilities.badge>
    @endif
</div>
