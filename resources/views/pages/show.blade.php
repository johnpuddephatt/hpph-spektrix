@extends('app') @section('content')

<div class="container py-24 prose prose-lg">
    <h1>{{ $page->title }}</h1>

    {!! $page->renderedContent !!} @endsection
</div>
