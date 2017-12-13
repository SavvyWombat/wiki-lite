@extends("wiki-lite::_layout")

@section('wiki-content')

<h1>Revision history for: {{ $page->title }}</h1>

<form method="POST" action="{{ route('wiki-lite.diff-post') }}">
    {{ csrf_field() }}
    <input type="hidden" name="slug" value="{{ $page->slug }}">

    <ul>
        @foreach ($revisions as $revision)
            <li>
                <input type="radio" name="from" value="{{ $revision->revision }}">
                <input type="radio" name="to" value="{{ $revision->revision }}">
                {{ $revision->updated_at->toDateTimeString() }}
                {{ $revision->title }}
            </li>
        @endforeach
    </ul>

    <div class="form-group">
        <input type="submit" name="diff" class="button button-primary" value="Show differences" />
    </div>
</form>

@endsection