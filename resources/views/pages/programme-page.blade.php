@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page->id])])

@section('title', $page->seo_title ?? $page->name)
@section('description', $page->seo_description ?? $page->introduction)
@section('image', $page->mainImage?->getUrl('landscape'))

@section('content')
    <livewire:programme />

    <script>
        
        
        document.addEventListener('livewire:navigated', () => {
            console.log('Livewire navigated');
            Alpine.start();
        });
    </script>


@endsection
