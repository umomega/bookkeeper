@php
// CONFIG
$link_limit = 6;

// SETUP
$half_total_links = floor($link_limit / 2);
$from = $paginator->currentPage() - $half_total_links;
$to = $paginator->currentPage() + $half_total_links;
if ($paginator->currentPage() < $half_total_links) {
   $to += $half_total_links - $paginator->currentPage();
}
if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
    $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
}
@endphp

<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
    <a class="pagination-previous{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}" href="{{ $paginator->previousPageUrl() }}">&laquo;</a>
    <a class="pagination-next{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}" href="{{ $paginator->nextPageUrl() }}">&raquo;</a>

    <ul class="pagination-list">
        @if($from >= 1)
            <li><a class="pagination-link{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}" href="{{ $paginator->url(1) }}">1</a></li>
            @if($from >= 2)
                <li><span class="pagination-ellipsis">&hellip;</span></li>
            @endif
        @endif

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            @if ($from < $i && $i < $to)
                <li><a class="pagination-link{{ ($paginator->currentPage() == $i) ? ' is-current' : '' }}" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
            @endif
        @endfor

        @if($to <= $paginator->lastPage())
            @if(($to + 1) <= $paginator->lastPage())
                <li><span class="pagination-ellipsis">&hellip;</span></li>
            @endif
            <li><a class="pagination-link{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif
    </ul>

</nav>
