@extends('app') @section('content')

<div class="container prose prose-lg py-24">
    <h1>{{ $post->title }}</h1>

    {!! $post->renderedContent !!} @endsection
</div>
