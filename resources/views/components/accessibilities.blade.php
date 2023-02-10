@props(['dark' => false, 'captioned' => false, 'signedbsl' => false, 'audiodescribed' => false, 'specialevent' => ''])

<div {{ $attributes->class(['flex flex-row gap-0.5']) }}>

    @if ($specialevent ?? null)
        <x-accessibilities.badge :dark="$dark" :class="$dark ? 'pl-1' : 'py-0.5 font-bold !font-sans !uppercase'" :title="'+' . $specialevent">
            +{{ $specialevent }}
        </x-accessibilities.badge>
    @endif
    @if ($captioned ?? null)
        <x-accessibilities.badge title="Captioned" :dark="$dark">C</x-accessibilities.badge>
    @endif
    @if ($signedbsl ?? null)
        <x-accessibilities.badge title="Signed BSL" :dark="$dark">BSL</x-accessibilities.badge>
    @endif
    @if ($audiodescribed ?? null)
        <x-accessibilities.badge title="Audio described" :dark="$dark">AD</x-accessibilities.badge>
    @endif
</div>
