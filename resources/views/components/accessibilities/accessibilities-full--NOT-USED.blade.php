@props([
    'dark' => false,
    'captioned' => false,
    'signedbsl' => false,
    'audiodescribed' => false,
    'autism_friendly' => false,
    'toddler_friendly' => false,
    'specialevent' => '',
])

<div {{ $attributes }}>

    @if ($specialevent ?? null)
        <span>
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full pl-1 pr-2 text-center">

            +{{ $specialevent }}
        </span>
    @endif
    @if ($captioned ?? null)
        <abbr title="Captioned"
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full px-2 text-center no-underline">
            C
        </abbr>
    @endif
    @if ($signedbsl ?? null)
        <abbr title="Signed BSL"
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full px-2 text-center no-underline">
            BSL</abbr>
    @endif
    @if ($audiodescribed ?? null)
        <abbr title="Audio Described"
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full px-2 text-center no-underline">
            AD</abbr>
    @endif
    @if ($autism_friendly ?? null)
        <abbr title="Autism-friendly screening"
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full px-2 text-center no-underline">
            Autism</abbr>
    @endif
    @if ($toddler_friendly ?? null)
        <abbr title="Toddler-friendly screening"
            class="{{ $dark ? 'bg-gray-dark text-white' : 'bg-sand-light' }} type-xs-mono inline-block rounded-full px-2 text-center no-underline">
            Toddler</abbr>
    @endif
</div>
