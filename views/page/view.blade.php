@extends("wiki-lite::_layout")

@section('wiki-content')

<h1>{{ $page->title }}</h1>

<a href="{{ route('wiki-lite.edit', $page->slug) }}">Edit</a>

{!! Markdown::convertToHtml(wikilinks($page->content)) !!}

@endsection