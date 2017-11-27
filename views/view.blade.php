@extends("wiki-lite::layout")

@section('wiki-content')
<h1>{{ $page->title }}</h1>

{{ $page->content }}

@endsection