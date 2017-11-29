@extends("wiki-lite::layout")

@section('wiki-content')
<ul>
    <li><a href="{{ config('wiki-lite.base') }}">WikiLite</a></li>
    @if ($page->parent)
        @include ('wiki-lite::_breadcrumb', [ 'page' => $page->parent ])
    @endif
</ul>

<h1>{{ $page->title }}</h1>

{{ $page->content }}

@include('wiki-lite::_pagelist', [ 'pages' => $page->pages ])

@endsection