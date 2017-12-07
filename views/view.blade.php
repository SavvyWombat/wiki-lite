@extends("wiki-lite::layout")

@section('wiki-content')

<h1>{{ $page->title }}</h1>

{!! Markdown::convertToHtml(wikilinks($page->content)) !!}

@include('wiki-lite::_pagelist', [ 'pages' => $page->pages ])

@endsection