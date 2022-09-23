@props(['dark' => false, 'captioned' => false, 'signedbsl' => false, 'audiodescribed' => false])

@if ($captioned || $signedbsl || $audiodescribed)
    &bullet;
@endif

@if ($captioned ?? null)
    <span
        {{ $attributes->class(['type-annotation inline-block w-6 rounded-full  pt-1 pb-0.5 text-center font-mono', 'bg-gray-dark text-white' => $dark, 'bg-gray' => !$dark]) }}>
        C
    </span>
@endif
@if ($signedbsl ?? null)
    <span
        {{ $attributes->class(['type-annotation inline-block w-10 rounded-full  pt-1 pb-0.5 text-center font-mono', 'bg-gray-dark text-white' => $dark, 'bg-gray' => !$dark]) }}>
        BSL</span>
@endif
@if ($audiodescribed ?? null)
    <span
        {{ $attributes->class(['type-annotation inline-block w-8 rounded-full  pt-1 pb-0.5 text-center font-mono', 'bg-gray-dark text-white' => $dark, 'bg-gray' => !$dark]) }}>
        AD</span>
@endif
