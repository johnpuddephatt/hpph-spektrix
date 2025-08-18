<div x-init="$dispatch('eventcount', { number: {{ $filtered ? $instances->count() : 0 }}, })">
    @foreach($instances as $date => $events)
        <div >
<div id="{{ Str::slug($events->first()->first()->start_date) }}" class="lg:h-0 absolute left-0 right-0 h-9 bg-sand-light"></div>
               <h3 class="flex lg:block justify-center lg:border-b border-sand sticky top-3 lg:top-[6.95rem] z-10 type-xs-mono lg:bg-sand-light container   first:mt-0">
                <a href="#{{ Str::slug($events->first()->first()->start_date) }}" class="bg-sand-light block rounded-full px-6 py-2.5 lg:py-3.5 lg:px-0">
                {{ $events->first()->first()->start_date}}
                </a>
            </h3>
            <div>
                @foreach($events as $eventId => $instances)
    
    <div
        class="border-b-[1rem] border-sand-light last:border-b-0 container py-4  relative flex flex-wrap lg:flex-nowrap flex-row items-start lg:gap-6">

        <div class="w-1/2 md:w-1/4 pl-2 lg:pl-0 md:ml-[25%] lg:ml-0 lg:w-2/12 relative aspect-video flex flex-col">
            <div class="w-full bg-sand-dark relative flex-1 rounded overflow-hidden">
                    @if ($instances->first()->event->featuredImage)
                    {!! $instances->first()->event->featuredImage->img('wide')->attributes([
                        'class' => 'group-hover:scale-105 transition duration-500 block w-full absolute max-w-none inset-0',
                        'loading' => 'lazy',
                    ]) !!}
                @endif
                </div>
              

            </div>

        <div class="max-lg:-order-1 flex  w-1/2 pr-4 lg:pr-0 flex-col self-stretch items-start lg:w-4/12">
            <h4 class="type-regular  mb-auto overflow-hidden text-ellipsis">
                <a class="before:absolute before:inset-0"
                    href="{{ route('event.show', ['event' => $instances->first()->event->slug]) }}">
                    {{ $instances->first()->event->name }}
                    <x-certificate class="align-middle" :dark="true" :certificate="$instances->first()->event->certificate_age_guidance" />
                </a>
            </h4>

            {{-- @if ($instances->first()->special_event || $instances->first()->format)
                <div class="lg:hidden mt-2">
                    <x-special-event-badge>{{ $instances->first()->special_event }}</x-special-event-badge>
                    <x-special-event-badge>{{ $instances->first()->format }}</x-special-event-badge>
                </div>
            @endif --}}

            @if ($instances->first()->event->subtitle)
                <p class="pt-2 leading-none">{{ $instances->first()->event->subtitle }}</p>
            @endif
        </div>

        <div
    class=" mt-4 lg:mt-0 lg:border-l lg:border-gray-light flex-grow self-stretch lg:pl-4 flex flex-col divide-y divide-gray-light gap-2 lg:w-4/12">
            @foreach ($instances as $instance)     

<div class="flex gap-4 lg:gap-2 py-4 items-start first:pt-0 flex-row">
            
    <div class="w-1/2">
                <div class=" text-center type-mono bg-black py-2 rounded px-6 text-white">{{ $instance->start->format('H:i') }}</div>
    </div>
                
            
<div class="flex flex-wrap items-start gap-2">
    @if (nova_get_setting('display_availability_badge', false))
                    
                        <x-availability-badge :instance="$instance"  
                   />
                    
                @endif

      @if ($instance->strand)
                    <x-strand.badge :dark="false" class="" :strand="$instance->strand" />
                @endif

                  @if ($instance->format)
                    <x-special-event-badge>{{ $instance->format }}</x-special-event-badge>
                @endif
                @if($instance->special_event)
                <x-special-event-badge>{{ $instance->special_event }}</x-special-event-badge>
                @endif

            <x-accessibilities :captioned="$instance->captioned" :signedbsl="$instance->signed_bsl" :audiodescribed="$instance->event->audio_description" :autism_friendly="$instance->autism_friendly" :toddler_friendly="$instance->toddler_friendly" />
    

            
          
            
            </div>
        </div>
            
            @endforeach
        </div> 
    </div>

        @endforeach
    </div>
        
</div>
    @endforeach
</div>