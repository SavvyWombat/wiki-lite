@if (count($pages))
<ul>
    @foreach($pages as $page)
        <ul>{{ wikilink($page->title) }}</ul>
    @endforeach
</ul>
@endif