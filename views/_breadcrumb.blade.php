@if ($page->parent)
    @include ('wiki-lite::_breadcrumb', [ 'page' => $page->parent ])
@endif
<li>{{ wikilink($page->title) }}</li>