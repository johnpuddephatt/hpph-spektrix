<div class="container grid gap-x-6 gap-y-16 lg:grid-cols-2 xl:grid-cols-3">
    @foreach ($posts as $post)
        <a href="{{ route('post.show', ['post' => $post->slug]) }}" class="flex flex-col">
            <p class="type-xs-mono mb-2">
                {{ $post->created_at->format('j F Y') }}
                @if ($post->tags->count())
                    &bullet;
                    <x-post-tags :tags="$post->tags" />
                @endif
            </p>
            @if ($post->featuredImage)
                {!! $post->featuredImage->img('landscape', ['class' => 'rounded block'])->toHtml() !!}
            @else
                <div class="rounded bg-gray pt-[66.7%]"></div>
            @endif
            <h3 class="type-regular mt-4 mb-1 max-w-xl">{{ $post->title }}</h3>
            <p class="max-w-xl pb-4">{{ $post->introduction }}</p>

            <div class="mt-auto flex flex-row items-center gap-2 border-t border-gray-light pt-2">
                @if ($post->user->avatar)
                    <img class="h-auto w-6 rounded lg:w-10" src="{!! url($post->user->avatar) !!}">
                @endif
                <p class="type-xs-mono">Written by <br>{{ $post->user->name }}</p>
            </div>
        </a>
    @endforeach
</div>
