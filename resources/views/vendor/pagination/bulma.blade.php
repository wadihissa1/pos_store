@if ($paginator->hasPages())
    <nav class="pagination is-centered is-small is-rounded mt-5" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        @if ($paginator->onFirstPage())
            <a class="pagination-previous" disabled aria-label="@lang('pagination.previous')">&lsaquo;</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-previous" aria-label="@lang('pagination.previous')">&lsaquo;</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-next" aria-label="@lang('pagination.next')">&rsaquo;</a>
        @else
            <a class="pagination-next" disabled aria-label="@lang('pagination.next')">&rsaquo;</a>
        @endif

        <ul class="pagination-list">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <a class="pagination-link is-current" aria-current="page" aria-label="Page {{ $page }}">{{ $page }}</a>
                            @else
                                <a href="{{ $url }}" class="pagination-link" aria-label="Go to page {{ $page }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif
