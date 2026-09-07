<div class="flex flex-col bg-sand-dark">
    @include('components.journal-filter')

    <x-journal-grid :posts="$posts" />

    @if ($posts->isEmpty())
        <p class="type-regular container pb-24">No posts found.</p>
    @endif

    <div class="container my-8">
        {{ $posts->links() }}
    </div>
</div>
