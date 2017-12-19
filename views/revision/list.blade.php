@extends("wiki-lite::_layout")

@section('wiki-content')
<article class="wiki-lite wiki-lite-history">
    <h1>Revision history for: <a class="wikilink" href="{{ route('wiki-lite.view', $page->slug) }}">{{ $page->title }}</a></h1>

    <form method="POST" action="{{ route('wiki-lite.diff-post') }}">
        {{ csrf_field() }}
        <input type="hidden" name="slug" value="{{ $page->slug }}">

        <ul class="wiki-lite-revision-list">
            <li>
                <span>from</span>
                <span>to</span>
                <span>date</span>
                <span>title</span>
            </li>
            @foreach ($revisions as $revision)
                <li>
                    <span><input type="radio" name="from" value="{{ $revision->revision }}"></span>
                    <span><input type="radio" name="to" value="{{ $revision->revision }}"></span>
                    <span>{{ $revision->updated_at->toDateTimeString() }}</span>
                    <span>{{ $revision->title }}</span>
                </li>
            @endforeach
        </ul>

        <div class="form-group">
            <input type="submit" name="diff" class="button button-primary" value="Show differences" />
        </div>
    </form>
</article>
@endsection