@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'users', 'resourceId' => $user->id])])
@section('title', $user->name)
@section('description', $user->role_title . '. ' . $user->role_description)
@section('image', $user->featuredImage?->getUrl('portrait'))

@section('menu_right')
    @if (isset($settings['team_page']))
        <a class="type-xs-mono hidden relative z-50 border-transparent lg:inline-block uppercase border-2 pl-1 pr-4 py-2 rounded hover:border-sand"
            href="{{ \App\Models\Page::find($settings['team_page'])?->url }}{{ $settings['team_page_hash'] ?? null }}">@svg('chevron-right', ' align-top h-4 w-4 inline-block transform rotate-180 origin-center')
            Back </a>
    @endif
@endsection

@section('content')
    <div class="fixed bg-black -z-10 inset-0 h-[75vh] lg:h-screen lg:w-1/2">
        @if ($user->featuredImage)
            {{ $user->featuredImage->img('portrait')->attributes(['class' => 'h-full w-full object-cover']) }}
        @endif
    </div>

    <div class="mt-[75vh] lg:mt-0 lg:ml-[50%] min-h-screen bg-sand relative">
        <div class="bg-sand-light pt-6 pb-12 lg:h-[66.6vh] flex flex-col">
            <div class="container lg:hidden">
                @if (isset($settings['team_page']))
                    <a class="type-xs-mono relative z-50 border-transparent mb-4 inline-block uppercase border-2 pl-1 pr-4 py-2 rounded hover:border-sand"
                        href="{{ \App\Models\Page::find($settings['team_page'])?->url }}{{ $settings['team_page_hash'] ?? null }}">@svg('chevron-right', ' align-top h-4 w-4 inline-block transform rotate-180 origin-center')
                        Back </a>
                @endif
            </div>
            <div class="container my-auto">
                <h2 class="type-medium lg:type-large">{{ $user->name }}</h2>
                <p class="type-regular lg:type-medium !font-normal">{{ $user->role_title }}</p>
            </div>
            <div class="type-regular pt-12 max-w-2xl ml-0 container !font-normal">{{ $user->role_description }}</div>
        </div>
        @if ($user->content)
            <div class="container py-16">
                @foreach ($user->content as $layout)
                    @include('blocks.' . $layout->name(), ['layout' => $layout, 'dark' => false])
                @endforeach
            </div>
        @endif
    </div>

@endsection
