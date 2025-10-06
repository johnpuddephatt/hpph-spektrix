<div class="flex flex-col bg-sand-dark">
    @if (count($tags))
        @include('components.journal-filter')
    @endif

    <x-journal-grid :posts="$posts" />

    <div class="container my-8">
        {{ $posts->links() }}
    </div>
</div>
