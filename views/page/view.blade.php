@extends("wiki-lite::_layout")

@section('wiki-content')

<article class="wiki">
    <h1>{{ $page->title }}</h1>

    <nav>
        <a href="{{ route('wiki-lite.edit', $page->slug) }}">Edit</a>
        <a href="{{ route('wiki-lite.revisions', $page->slug) }}">History</a>
    </nav>

    {!! Markdown::convertToHtml(wikilinks($page->content)) !!}

</article>
@endsection