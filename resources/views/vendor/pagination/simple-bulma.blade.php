@if ($paginator->hasPages())
    <nav class="pagination is-centered is-small mt-5" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
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
    </nav>
@endif
