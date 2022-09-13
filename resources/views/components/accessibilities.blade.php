@if ($captioned ?? ($signedbsl ?? ($audiodescribed ?? null)))
    &bullet;
@endif

@if ($captioned ?? null)
    <span class="inline-block h-6 w-6 rounded-full bg-gray-dark pt-0.5 text-center font-mono text-white">C
    </span>
@endif
@if ($signedbsl ?? null)
    <span class="inline-block h-6 w-6 rounded-full bg-gray-dark pt-0.5 font-mono text-white">BSL</span>
@endif
@if ($audiodescribed ?? null)
    <span class="inline-block h-6 w-6 rounded-full bg-gray-dark pt-0.5 font-mono text-white">AD</span>
@endif
