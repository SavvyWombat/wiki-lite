@if ($page->parent)
    @include ('wiki-lite::_breadcrumb', [ 'page' => $page->parent ])
@endif
<li>{!! Markdown::convertToHtml(wikilink($page->title)) !!}</li>