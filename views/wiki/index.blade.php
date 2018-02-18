@extends("savvywombat/wiki-lite::_layout")

@section('wiki-content')
<article class="wiki-lite wiki-lite-index">
    <h1>WikiLite</h1>

    @include('savvywombat/wiki-lite::_pagelist')
</article>
@endsection