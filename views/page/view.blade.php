@extends("wiki-lite::_layout")

@section('wiki-content')

<article class="wiki">
    <h1>{{ $page->title }}</h1>

    <nav>
        <a href="{{ route('wiki-lite.edit', $page->slug) }}">Edit</a>
        <a href="{{ route('wiki-lite.revisions', $page->slug) }}">History</a>
    </nav>

    {!! Markdown::convertToHtml(wikilinks($page->content)) !!}

    <nav class="wiki-link-backs">
        <h2>Pages which link back to this one</h2>

        <ul>
            @foreach ($page->linksBack as $linkBack)
                <li>{!! Markdown::convertToHtml(wikilink($linkBack->sourcePage->title)) !!}</li>
            @endforeach
        </ul>
    </nav>

</article>
@endsection