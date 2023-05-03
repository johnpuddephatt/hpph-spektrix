@props(['instance'])

<div class="flex flex-row items-center gap-2">
    <span
        class="type-xs-mono bg-gray-dark rounded-full text-white block no-underline px-2 text-center cursor-default z-[2]"
        x-show="instance.captioned">Captioned</span>
    <span title="Signed BSL"
        class="type-xs-mono bg-gray-dark rounded-full text-white block no-underline px-2 text-center cursor-default z-[2]"
        x-show="instance.signed_bsl">BSL</span>
    <span
        class="type-xs-mono bg-gray-dark rounded-full text-white block no-underline px-2 text-center cursor-default z-[2]"
        x-show="instance.relaxed">Relaxed</span>
    <abbr title="Audio Description"
        class="type-xs-mono bg-gray-dark rounded-full text-white block no-underline px-2 text-center cursor-default z-[2]"
        x-show="instance.event.audio_description">AD</abbr>
    <span class="type-xs py-0.5 text-black uppercase inline-block rounded px-2 bg-sand-light !font-bold !no-underline"
        x-show="instance.special_event" x-text="`with ${instance.special_event}`"></span>
</div>
