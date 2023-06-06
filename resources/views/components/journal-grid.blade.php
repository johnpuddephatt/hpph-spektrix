@props(['dark' => false, 'posts', 'post_class' => null])

<div
    {{ $attributes->class('container pt-4 lg:pt-6 grid pb-24 gap-x-6 gap-y-8 lg:gap-y-16 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4') }}>
    @foreach ($posts as $post)
        <x-journal-card :class="$post_class" :wire:key="$post->id" :post="$post" :dark="$dark" />
    @endforeach
</div>
