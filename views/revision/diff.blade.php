@extends("savvywombat/wiki-lite::_layout")

@section('wiki-content')
<article class="wiki-lite wiki-lite-diff">
    <h1>Comparing <a class="wiki-lite-wikilink" href="{{ route('wiki-lite.view', $page->slug) }}">{{ $page->title }}</a></h1>

    

    <div class="wiki-lite-diff-header">
        <ul class="wiki-lite-diff-item">
            <li class="wiki-lite-diff-before">old</li>
            <li class="wiki-lite-diff-before">new</li>
        </ul>

        <ul class="wiki-lite-diff-item">
            <li class="wiki-lite-diff-before">{{ $before->title }}</li>
            <li class="wiki-lite-diff-after">{{ $after->title }}</li>
        </ul>

        <ul class="wiki-lite-diff-item">
            <li class="wiki-lite-diff-before">{{ $before->updated_at->toDateTimeString() }}</li>
            <li class="wiki-lite-diff-after">{{ $after->updated_at->toDateTimeString() }}</li>
        </ul>
    </div>

    <pre class="wiki-lite-diff">{{ $diff }}</pre>
</article>
@endsection