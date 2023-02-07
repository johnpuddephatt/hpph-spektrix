@props(['dark' => false, 'captioned' => false, 'signedbsl' => false, 'audiodescribed' => false, 'specialevent' => ''])

<div {{ $attributes }}>

    @if ($specialevent ?? null)
        <span
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono py-0.5 !leading-none inline-block rounded-full pl-1 pr-2 text-center">

            +{{ $specialevent }}
        </span>
    @endif
    @if ($captioned ?? null)
        <span
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full px-2 text-center">
            C
        </span>
    @endif
    @if ($signedbsl ?? null)
        <span
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full px-2 text-center">
            BSL</span>
    @endif
    @if ($audiodescribed ?? null)
        <span
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full px-2 text-center">
            AD</span>
    @endif
</div>
