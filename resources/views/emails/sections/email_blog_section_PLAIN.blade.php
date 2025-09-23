@php
    $post = \App\Models\Post::withoutGlobalScopes()->find($section->post);
@endphp

@if ($post)


From the HPPH journal
{!! $post->title !!}

{!! $post->introduction !!}

{{ $post->url }}

@endif
