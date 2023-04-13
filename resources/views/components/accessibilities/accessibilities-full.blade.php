@props(['dark' => false, 'captioned' => false, 'signedbsl' => false, 'audiodescribed' => false, 'relaxed' => false, 'specialevent' => ''])
FULL?
<div {{ $attributes }}>

    @if ($specialevent ?? null)
        <span>
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full pl-1 pr-2 text-center">

            +{{ $specialevent }}
        </span>
    @endif
    @if ($captioned ?? null)
        <abbr title="Captioned"
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block no-underline rounded-full px-2 text-center">
            C
        </abbr>
    @endif
    @if ($signedbsl ?? null)
        <abbr title="Signed BSL"
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block no-underline rounded-full px-2 text-center">
            BSL</abbr>
    @endif
    @if ($audiodescribed ?? null)
        <abbr title="Audio Described"
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block no-underline rounded-full px-2 text-center">
            AD</abbr>
    @endif
    @if ($relaxed ?? null)
        <abbr title="Relaxed"
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block no-underline rounded-full px-2 text-center">
            R</abbr>
    @endif
</div>
