<div class="container mt-4 mb-12 grid grid-cols-2 gap-x-4 gap-y-8 lg:grid-cols-3 xl:grid-cols-4">
    @foreach ($users as $user)
        <a href="{{ route('user.show', ['user' => $user->slug]) }}">
            <img class="mb-4 block w-full rounded" src="{{ $user->avatar }}" />
            <div class="flex flex-row items-center justify-between gap-4">
                <div class="truncate">
                    <h2 class="type-medium mb-1 truncate">{{ $user->name }}</h2>
                    <div class="type-xs-mono truncate">{{ $user->role_title }}</div>
                </div>
                <div class="rounded-[50%] bg-yellow">
                    @svg('chevron-right', 'h-8 w-8 my-3 mx-6')
                </div>
            </div>
        </a>
    @endforeach
</div>
