@extends('layouts.default', ['header_colour' => 'light', 'header_position' => 'default', 'edit_link' => route('nova.pages.edit', ['resource' => 'events', 'resourceId' => $event->id])]) @section('content')
    <div class="fixed inset-0 h-[calc(100vh-1rem)] w-full overflow-hidden">
        @if ($event->featuredImage)
            {!! $event->featuredImage->img('wide', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() !!}
        @endif
    </div>

    <div class="relative z-10 mt-[calc(100vh-4.75rem-1rem)]">
        <div class="absolute bottom-full left-0 right-0 z-10 mt-auto" id="event-content">
            <div class="container pt-48 pb-12">
                <h1 class="mb-4 text-6xl font-bold text-white">{{ $event->name }}</h1>
                <div class="inline-block rounded bg-white px-2">{{ $event->certificate_age_guidance }}</div>
            </div>
        </div>

        <div class="to-transparent pointer-events-none absolute bottom-full left-0 right-0 h-96 bg-gradient-to-t from-black">
        </div>


        <a href="#event-content"
            class="fixed left-1/2 top-[calc(100vh-4rem-1rem)] z-20 -translate-x-1/2 transform text-5xl text-white">@svg('down-chevron', 'h-16 w-16')</a>

    </div>

    <div class="relative z-20 mt-[calc(100vh-4.75rem-1rem)] bg-white py-24">


        <div class="container relative z-30">
            <div class="prose prose-lg">

                <div class="flex gap-4">
                    @foreach ($event->gallery as $galleryItem)
                        {{ $galleryItem->img('wide', ['class' => 'w-full absolute h-full inset-0 object-cover'])->toHtml() }}
                    @endforeach
                </div>
                {!! $event->renderedDescription !!}

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.</p>

            </div>
        </div>
    </div>
@endsection
