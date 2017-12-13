@extends("wiki-lite::_layout")

@section('wiki-content')

@if ($page->uuid)
    <h1>Editing {{ $page->title }}</h1>
@else
    <h1>Creating new page</h1>
@endif

@include("wiki-lite::_form")

@endsection