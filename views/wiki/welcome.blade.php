@extends("savvywombat/wiki-lite::_layout")

@section('wiki-content')
<article class="wiki-lite wiki-lite-welcome">
    <h1>Welcome to WikiLite by SavvyWombat</h1>

    <p>
        Let's get this wiki started.
    </p>

    @include("savvywombat/wiki-lite::_form")
</article>
@endsection