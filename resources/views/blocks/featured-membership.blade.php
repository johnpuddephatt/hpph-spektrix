<div class="bg-black py-20 lg:py-36 text-center px-4 relative overflow-x-hidden">
    <video class="inset-0 absolute transition duration-1000 w-full h-full object-cover object-center" autoplay="true"
        preload="true" loop="true" muted="true" playsinline="true">
        <source type="video/mp4" src="{{ Storage::url($layout->video) }}" />
    </video>

    <h2 class="type-regular lg:type-medium relative text-white mb-2">
        {{ $layout->title }}
    </h2>
    <p class="type-xs-mono relative mb-24 text-white">
        {{ $layout->subtitle }}
    </p>
    <div class="relative w-full max-w-lg mx-auto">
        <div class="rounded pt-[56%] relative p-12 bg-black bg-opacity-25 backdrop-blur-sm border border-gray-medium">
            <img src="{{ Storage::url($layout->membership->logo) }}"
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 mx-auto w-40"></inline-svg>
            <div
                class="type-xs-mono absolute left-0 transform text-opacity-50 text-white top-1/2 -rotate-90 origin-center">
                Member #001
            </div>
        </div>
    </div>

    <spektrix-memberships class="relative block mx-auto max-w-xs pb-2"
        client-name="{{ $settings['spektrix_client_name'] }}" custom-domain="{{ $settings['spektrix_custom_domain'] }}"
        membership-id="{{ $layout->membership->id }}">

        <button class="type-regular relative inline-block text-center mt-4 text-yellow" data-submit-membership>
            @svg('plus', 'mx-auto p-3 mt-12 mb-4 h-12 w-12 rounded-full border text-white border-gray-dark hover:bg-white hover:bg-opacity-25')
            Add to
            basket</button>
        <div class="absolute top-full left-0 right-0" data-success-container style="display: none;">
            <div class="type-regular max-w-xs text-black leading-tight py-2 px-6 bg-yellow-dark text-center">
                Added to basket</div>
            <p class="type-small text-white mt-4">Want your free membership to continue until your 26th birthday? After
                you’ve processed your order, visit your account page and provide us with your date of birth.</p>
        </div>
        <div class="absolute text-black font-bold top-full left-0 right-0 leading-tight py-2 px-6 bg-yellow-dark text-center"
            data-fail-container style="display: none;">Something went wrong.</div>
    </spektrix-memberships>

    <p class="type-xs-mono text-white mt-8">Proof of age will be required when you visit.</p>

</div>

<x-marquee class="!bg-sand" />
