<div class="bg-sand-dark flex flex-col">
    @if (count($tags))
        @include('components.journal-filter')
    @endif

    <x-journal-grid :posts="$posts" />

    {{ $posts->links() }}

</div>
