@extends("wiki-lite::_layout")

@section('wiki-content')

<h1>Revision history for: {{ $page->title }}</h1>

<ul>
    @foreach ($revisions as $revision)
        <li>
            {{ $revision->updated_at->toDateTimeString() }}
            {{ $revision->title }}
        </li>
    @endforeach
</ul>

@endsection