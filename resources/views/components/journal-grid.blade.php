@props(['dark' => false, 'posts', 'post_class' => null])

<div class="container grid pb-24 gap-x-6 gap-y-8 lg:gap-y-16 lg:grid-cols-3">
    @foreach ($posts as $post)
        <x-journal-card :class="$post_class" wire:key="$post->id" :post="$post" :dark="$dark" />
    @endforeach
</div>
