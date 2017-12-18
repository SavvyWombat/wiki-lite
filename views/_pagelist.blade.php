@if (count($pages))
<ul class="wiki-lite-page-list">
    @foreach($pages as $page)
        <li>{!! Markdown::convertToHtml(wikilink($page->title)) !!}</li>
    @endforeach
</ul>
@endif