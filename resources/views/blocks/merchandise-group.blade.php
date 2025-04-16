@push('webComponents', '#spektrix-merchandise')

<div class="bg-black py-24 container max-w-7xl px-4 text-white text-center">
    @if($layout->pretitle)
    <p class="type-xs-mono text-center container mb-2">{{ $layout->pretitle }}</p>
    @endif
    <h2 class="type-medium" style="color: @yield('color')">{{ $layout->title }}</h2>

    <div class="mt-16 flex justify-center flex-wrap gap-6 lg:gap-12">
        @foreach ($layout->merchandise as $merchandise)
        
            @php($merchandise = $merchandise->merchandise)
            <div class="bg-black-light overflow-hidden md:w-2/5 rounded  text-white">
                <spektrix-merchandise class="relative" client-name="{{ $settings['spektrix_client_name'] }}" merchandise-quantity="1"
                    custom-domain="{{ $settings['spektrix_custom_domain'] }}" merchandise-item-id="{{ $merchandise->id }}">

@if($layout->display_images)
                    <div class="overflow-hidden bg-white/10">
                        {!! $merchandise->featuredImage->img('landscape')->attributes(['class' => 'group-hover:scale-105 transition duration-500 rounded w-full block']) !!}
                    </div>
                    @endif
                    <div class="p-8">
                        <h3 class="type-regular mb-4">{{ $merchandise->name }}</h3>     
                        <div>{{ $merchandise->description}}</div>
                        @if($layout->display_quantity_controls)

                        <div class="flex gap-2 mt-4 justify-center items-center">                    
                            <button  style="background-color: @yield('color')" class="text-black leading-none  type-regular rounded bg-white py-1 px-2.5" data-decrement-quantity> - </button>
                            <label for="quantity">
                                Quantity:
                                <span data-display-quantity></span>   
                            </label>
                            <button  style="background-color: @yield('color')" class="text-black leading-none type-regular rounded bg-white py-1 px-2.5" data-increment-quantity> + </button>
                        </div>
                        @endif
                        <button style="background-color: @yield('color')" data-submit-merchandise class="mt-4 w-full type-regular flex-grow text-black rounded py-3 pl-4 pr-3">Add to basket @svg('arrow-right', 'inline-block h-4 w-4 ml-auto')</button>
                    </div>
                    <div class="mt-4 type-regular text-yellow leading-tight py-6 px-6  bg-black flex justify-between"
                        data-success-container style="display: none;"><div>Added to basket</div>
                        <a href="/basket" class="text-white underline">View basket</a> 
                        </div>
                    <div class=" mt-4 text-yellow font-bold leading-tight py-4 px-6 bg-black text-center"
                        data-fail-container style="display: none;">Something went wrong.</div>
                </spektrix-merchandise>

            </div>
        @endforeach
    </div>
</div>
