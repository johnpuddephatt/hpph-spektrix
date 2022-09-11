@extends('layouts.default', ['header_position' => 'absolute', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    @include('components.pageheader-default')

    @if ($page->content)
        <div class="my-16">
            @foreach ($page->content->blocks as $block)
                @includeIf('vendor.nova-editor-js.' . $block->type,
                    array_merge((array) $block->data, ['_tunes' => $block->tunes ?? [], '_align' => 'right']))
            @endforeach
        </div>
    @endif
@endsection
