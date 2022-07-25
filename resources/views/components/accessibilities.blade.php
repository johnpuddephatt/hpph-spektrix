@if ($captioned ?? ($signedbsl ?? ($audiodescribed ?? null)))
    &bullet;
@endif

@if ($captioned ?? null)
    <span class="inline-block h-6 w-6 rounded-full bg-gray-dark text-center font-mono leading-normal text-white">C
    </span>
@endif
@if ($signedbsl ?? null)
    <span class="inline-block h-6 w-6 rounded-full bg-gray-dark font-mono leading-normal text-white">BSL</span>
@endif
@if ($audiodescribed ?? null)
    <span class="inline-block h-6 w-6 rounded-full bg-gray-dark font-mono leading-normal text-white">AD</span>
@endif
