@extends("wiki-lite::_layout")

@section('wiki-content')

<h1>Not found</h1>

<p>
    "{{ $page->title }}" doesn't seem to exist. Create a new page?
</p>

@include("wiki-lite::_form")

@endsection