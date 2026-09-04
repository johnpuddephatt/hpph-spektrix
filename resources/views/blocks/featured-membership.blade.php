<div id="{{ $layout->menuAnchor() }}" class="scroll-mt-24 bg-black-light py-20 lg:py-36      px-4 relative overflow-x-hidden">

    <div class="grid bg-black rounded items-center lg:grid-cols-3 overflow-hidden">
   <img class="p-4 aspect-square object-contain" src="{{  Storage::url($layout->membership->image) }}"/>

   <div class="lg:col-span-2 py-8 px-8">
    <h2 class="type-medium lg:type-large relative text-white mb-2">
        {{ $layout->title }}
    </h2>
    <p class="type-small relative mb-12 text-white">
        {{ $layout->subtitle }}
    </p>
    
   <ul class="text-white divide-y divide-black-light max-w-lg">
                    @foreach ($layout->membership->benefits as $benefit)
                        <li
                            class="py-3 type-xs-mono lg:py-4">
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>

    <spektrix-memberships class="relative block mt-12 max-w-lg pb-2"
    client-name="{{ $settings['spektrix_client_name'] }}" custom-domain="{{ $settings['spektrix_custom_domain'] }}"
    membership-id="{{ $layout->membership->id }}">    
        <button class="type-regular w-full bg-yellow rounded text-center py-4 text-black hover:bg-opacity-90 transition"
        data-submit-membership>Add to basket</button>
        <div class="-mt-12 relative" data-success-container style="display: none;">
            <div class="type-regular max-w-lg rounded text-black leading-tight py-4 px-6 bg-yellow-dark text-center">
                Added to basket</div>
                <p class="type-small text-white mt-4">Want your free membership to continue until your 26th birthday? After
                    you’ve processed your order, visit your account page and provide us with your date of birth.</p>
                </div>
                <div class="absolute text-black font-bold top-full left-0 right-0 leading-tight py-2 px-6 bg-yellow-dark text-center"
                data-fail-container style="display: none;">Something went wrong.</div>
            </spektrix-memberships>
            
        </div>
    

</div>
</div>

<x-marquee class="!bg-sand" />
