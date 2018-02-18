@extends("savvywombat/wiki-lite::_layout")

@section('wiki-content')

<article class="wiki-lite wiki-lite-page">
    <h1>{{ $page->title }}</h1>

    <nav class="wiki-lite wiki-lite-page-navigation">
        <ul>
            <li><a href="{{ route('wiki-lite.edit', $page->slug) }}">Edit</a></li>
            <li><a href="{{ route('wiki-lite.revisions', $page->slug) }}">History</a></li>
        </ul>
    </nav>

    {!! Markdown::convertToHtml(wikilinks($page->content)) !!}

    <nav class="wiki-lite wiki-lite-link-backs">
        <h2>Pages which link back to this one</h2>

        <ul>
            @foreach ($page->linksBack as $linkBack)
                <li><a href="{{ route('wiki-lite.view', $linkBack->sourcePage->slug) }}">{{$linkBack->sourcePage->title}}</a></li>
            @endforeach
        </ul>
    </nav>

</article>
@endsection