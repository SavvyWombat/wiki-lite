@extends("wiki-lite::_layout")

@section('wiki-content')
<article class="wiki-lite wiki-lite-diff">
    <h1>Comparing {{ $page->title }}</h1>

    <div class="diff-list">
        <div class="diff-item">
            <p class="diff-before">{{ $before->title }}</p>
            <p class="diff-after">{{ $after->title }}</p>
        </div>

        <div class="diff-item">
            <p class="diff-before">{{ $before->updated_at->toDateTimeString() }}</p>
            <p class="diff-after">{{ $after->updated_at->toDateTimeString() }}</p>
        </div>
    </div>

    <pre>
        {{ $diff }}
    </pre>
</article>


@endsection