@if (count($pages))
<ul>
    @foreach($pages as $page)
        <ul>{!! Markdown::convertToHtml(wikilink($page->title)) !!}</ul>
    @endforeach
</ul>
@endif