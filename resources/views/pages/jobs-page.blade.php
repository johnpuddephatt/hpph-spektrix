@extends('layouts.default', ['header_background' => null, 'header_position' => 'absolute', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    <div class="relative h-[calc(100vh-1rem)] w-full overflow-hidden bg-black">
        <div class="relative">
            <div x-data="{}" x-init="console.log($el.scrollLeft);
            $el.firstElementChild.children[1].scrollIntoView({ behavior: 'auto', block: 'center', inline: 'center' });
            console.log($el.scrollLeft);"
                class="relative snap-x snap-mandatory overflow-x-auto scrollbar-hide">
                <div class="relative flex flex-row gap-8">
                    <div class="w-8 flex-none"></div>
                    @foreach ($page->content->header_images as $header_image)
                        <x-image class="w-[60vw] snap-center" :width="'60vw'" :src="$header_image->src" :srcset="$header_image->srcset" />
                    @endforeach
                    <div class="w-8 flex-none"></div>

                </div>

            </div>
            <div class="fade-to-top pointer-events-none absolute bottom-0 left-0 right-0 z-20 h-96">
            </div>

        </div>
        <div class="absolute bottom-0 left-0 right-0 z-20 mt-auto" id="event-content">
            <div class="relative z-20 mx-auto max-w-5xl px-4 pt-48 pb-6 text-center text-white 2xl:px-6">
                <h1 class="mb-8 text-6xl font-bold">{{ $page->name }}</h1>
                <p class="type-large mx-auto max-w-lg">{{ $page->introduction }}</p>
                <a href="#event-content" class="mx-auto mt-12 block w-16 text-5xl text-white">@svg('down-chevron', 'h-16 w-16')</a>
            </div>

            <div class="fade-to-top pointer-events-none absolute bottom-0 left-0 right-0 h-full">
            </div>

        </div>

    </div>

    @if ($page->content->welcome_text)
        <div class="relative bg-white">
            <div class="bg-yellow py-16 lg:py-32">
                <div class="container max-w-7xl text-center">
                    <h2 class="type-h5 lg:type-h3">{{ $page->content->welcome_text }}</h2>
                </div>
            </div>
        </div>
    @endif

    <div>
        <div class="container my-12 flex max-w-7xl flex-col gap-12 lg:flex-row xl:gap-16">
            @foreach ($page->content->highlights as $highlight)
                <div class="mx-auto max-w-md text-center lg:w-1/3">
                    {!! $page->getMedia('banner_' . $highlight->key)->first()->img('landscape', ['class' => 'rounded-full mb-6'])->toHtml() !!}

                    <h3 class="type-subtitle mb-4">{{ $highlight->attributes->title }}</h3>
                    <div>{{ $highlight->attributes->description }}</div>
                </div>
            @endforeach
        </div>
    </div>

    @if ($page->secondaryImage)
        {!! $page->secondaryImage->img('wide', ['class' => 'w-full'])->toHtml() !!}
    @endif

    <div class="bg-sand py-16">
        <div class="container">
            <h3 class="type-subtitle mb-12 text-center">Current jobs &amp; opportunities</h3>

            @foreach ($page->content->opportunities as $opportunity)
                <div class="flex flex-row items-center gap-3 border-b border-gray-light py-4">
                    <div class="w-16">{{ $loop->iteration }}</div>
                    <div class="type-subtitle w-1/3">{{ $opportunity->title }}</div>
                    <div class="">{{ $opportunity->type }} • Apply by {{ $opportunity->application_deadline }}</div>
                    <a class="type-subtitle ml-auto inline-block rounded bg-yellow py-2 px-16"
                        href="{{ route('opportunity.show', ['opportunity' => $opportunity->slug]) }}">Information</a>
                </div>
            @endforeach
        </div>
    </div>

    @if ($page->content->child_pages)
        <div class="container mt-6 mb-24 grid gap-4 lg:grid-cols-2">
            @foreach ($page->content->child_pages as $child_page)
                <div>
                    <x-image :width="'50vw'" class="mb-8 block w-full rounded" :src="$child_page->src" :srcset="$child_page->srcset" />
                    <h3 class="type-h4 mb-4">{{ $child_page->name }}</h3>
                    <p class="mb-8 max-w-md">{{ $child_page->introduction }}</p>
                    <a class="type-subtitle rounded bg-yellow px-12 py-2"
                        href="{{ route('page.show', ['page' => $child_page->slug]) }}">Find out more</a>
                </div>
            @endforeach
        </div>
    @endif

    @includeWhen(isset($page->content->banner), 'components.banner', ['banner' => $page->content->banner])

@endsection
