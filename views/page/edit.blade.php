@extends("savvywombat/wiki-lite::_layout")

@section('wiki-content')
<article class="wiki-lite wiki-lite-edit">
    @if ($page->uuid)
        <h1>Editing <a class="wikilink" href="{{ route('wiki-lite.view', $page->slug) }}">{{ $page->title }}</a></h1>
    @else
        <h1>Creating new page</h1>
    @endif

    @include("savvywombat/wiki-lite::_form")
</article>
@endsection