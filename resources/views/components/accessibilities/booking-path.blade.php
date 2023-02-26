@props(['instance'])

<div class="flex flex-row items-center gap-2">
    <span class="type-xs-mono px-2.5 py-1.5 h-7 text-center rounded-full bg-sand-light"
        x-show="instance.captioned">C</span>
    <span class="type-xs-mono px-4 py-1.5 h-7 text-center rounded-full bg-sand-light"
        x-show="instance.signed_bsl">BSL</span>
    <span class="type-xs-mono px-1.5 py-1.5 h-7 text-center rounded-full bg-sand-light"
        x-show="instance.audio_described">AD</span>
    <span class="type-xs-mono bg-black text-white rounded-full py-0.5 px-4 pl-2" x-show="instance.special_event"
        x-text="`+${instance.special_event}`"></span>
</div>
