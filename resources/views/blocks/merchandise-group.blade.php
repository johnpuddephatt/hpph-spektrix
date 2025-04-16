@push('webComponents', '#spektrix-merchandise')

<div class="bg-black relative border-y border-gray-dark py-24  text-white text-center">
<div class="container max-w-7xl px-4">
    @if($layout->pretitle)
    <p class="type-xs-mono text-center container mb-2">{{ $layout->pretitle }}</p>
    @endif
    <h2 class="type-medium" style="color: @yield('color')">{{ $layout->title }}</h2>

    <div class="mt-16 flex justify-center flex-wrap gap-6 lg:gap-12">
        @foreach ($layout->merchandise as $merchandise)
        
            @php($merchandise = $merchandise->merchandise)
            
                <spektrix-merchandise class="bg-black-light flex flex-col overflow-hidden md:w-2/5 rounded  text-white" client-name="{{ $settings['spektrix_client_name'] }}" merchandise-quantity="1"
                    custom-domain="{{ $settings['spektrix_custom_domain'] }}" merchandise-item-id="{{ $merchandise->id }}">

@if($layout->display_images)
                    <div class="overflow-hidden bg-white/10">
                        {!! $merchandise->featuredImage->img('landscape')->attributes(['class' => 'group-hover:scale-105 transition duration-500 rounded w-full block']) !!}
                    </div>
                    @endif
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="mb-8">
                            <h3 class="type-regular mb-4">{{ $merchandise->name }}</h3>     
                            <div>{{ $merchandise->description}}</div>
                            @if($layout->display_quantity_controls)

                            <div class="flex gap-2 mt-4 justify-center items-center">                    
                                <button  style="color: @yield('color'); border-color: @yield('color')" class="text-black border leading-none  type-regular rounded bg-transparent py-1 px-2.5" data-decrement-quantity> - </button>
                                <label for="quantity">
                                    Quantity:
                                    <span data-display-quantity></span>   
                                </label>
                                <button  style="color: @yield('color'); border-color: @yield('color')" class="text-black border leading-none type-regular bg-transparent rounded  py-1 px-2.5" data-increment-quantity> + </button>
                            </div>
                            @endif
                        </div>

                        <div class="relative mt-auto">
                            <button style="background-color: @yield('color')" data-submit-merchandise class="w-full border type-regular flex-grow text-black rounded py-3 pl-4 pr-3">Add to basket @svg('arrow-right', 'inline-block h-4 w-4 ml-4')</button>
                            <div class="absolute rounded left-0 right-0 inset-0 top-0 type-regular text-yellow leading-tight py-3 px-6  bg-black "
                            data-success-container style="display: none;">
                                <div class="flex justify-between">
                                    <div>Added to basket</div>
                                    <a href="/checkout" class="text-white underline">Go to checkout</a> 
                                </div>
                            </div>
                    
                            <div class="  absolute rounded left-0 inset-0  right-0 top-0 type-regular text-yellow leading-tight py-3 px-6 bg-black text-center"
                                data-fail-container style="display: none;">Something went wrong.
                            </div>
                        </div>
                    </div>
                    
                </spektrix-merchandise>

            
        @endforeach
    </div>
    </div>
</div>
