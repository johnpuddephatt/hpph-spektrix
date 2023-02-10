<div class="container grid gap-x-6 gap-y-8 lg:gap-y-16 lg:grid-cols-2 xl:grid-cols-3">
    @foreach ($posts as $post)
        <x-journal-card wire:key="$post->id" :post="$post" />
    @endforeach
</div>
