<div id="team" class="py-16 bg-black text-white">
    <div class="container lg:flex flex-row pb-16">
        <h3 class="type-medium mb-4 lg:w-1/2 text-yellow">{{ $layout->title }}</h3>
        <p class="max-w-lg">{{ $layout->subtitle }}</p>
    </div>
    <div class="flex flex-row gap-4 overflow-x-auto">
        @foreach ($layout->team as $user)
            <a href="{{ $user->url }}" class="group block text-center w-64 mx-6">
                {!! $user->featuredImage->img('portrait')->attributes(['class' => 'rounded block mb-8']) !!}
                <h3 class="type-xs-mono transition group-hover:text-yellow text-white">{{ $user->name }}</h3>
                <p class="type-xs-mono transition group-hover:text-white text-gray-medium">{{ $user->role_title }}</p>
            </a>
        @endforeach
    </div>
</div>
