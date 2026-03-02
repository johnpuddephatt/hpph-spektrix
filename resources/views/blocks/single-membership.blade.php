<div id="{{ Str::slug($layout->title) }}" class="relative overflow-x-hidden bg-black px-4 py-20 text-center lg:py-36">

    <img src="{{ Storage::url($layout->membership->logo) }}"
        class="absolute left-1/2 top-1/2 mx-auto w-40 -translate-x-1/2 -translate-y-1/2 transform"></inline-svg>
    <h2 class="type-regular lg:type-medium relative mb-2 text-white">
        {{ $layout->title }}
    </h2>
    <p class="type-xs-mono relative mb-24 text-white">
        {{ $layout->subtitle }}
    </p>

    <spektrix-memberships class="relative mx-auto block max-w-xs pb-2"
        client-name="{{ $settings['spektrix_client_name'] }}" custom-domain="{{ $settings['spektrix_custom_domain'] }}"
        membership-id="{{ $layout->membership->id }}">

        <button class="type-regular relative mt-4 inline-block text-center text-yellow" data-submit-membership>
            @svg('plus', 'mx-auto p-3 mt-12 mb-4 h-12 w-12 rounded-full border text-white border-gray-dark hover:bg-white hover:bg-opacity-25')
            Add to
            basket</button>
        <div class="absolute left-0 right-0 top-full" data-success-container style="display: none;">
            <div class="type-regular max-w-xs bg-yellow-dark px-6 py-2 text-center leading-tight text-black">
                Added to basket</div>

        </div>
        <div class="absolute left-0 right-0 top-full bg-yellow-dark px-6 py-2 text-center font-bold leading-tight text-black"
            data-fail-container style="display: none;">Something went wrong.</div>
    </spektrix-memberships>

</div>
