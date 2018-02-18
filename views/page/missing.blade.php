@extends("savvywombat/wiki-lite::_layout")

@section('wiki-content')
<article class="wiki-lite wiki-lite-not-found">
    <h1>Not found</h1>

    <p>
        "{{ $page->title }}" doesn't seem to exist. Create a new page?
    </p>

    @include("savvywombat/wiki-lite::_form")
</article>
@endsection