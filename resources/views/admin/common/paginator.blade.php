@if($paginator->hasPages())
<ul class="pagination pagination-rounded justify-content-end mb-0">
    <li class="page-item">
        <a class="page-link" href="@if ($paginator->onFirstPage()) javascript: void(0); @else {{ $paginator->previousPageUrl() }} @endif" aria-label="Previous">
            <span aria-hidden="true">«</span>
            <span class="sr-only">Previous</span>
        </a>
    </li>
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item"><a class="page-link" href="javascript: void(0);">{{ $element }}</a></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active"><a class="page-link" href="javascript: void(0);">{{ $page }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    <li class="page-item">
        <a class="page-link" href="@if ($paginator->hasMorePages()) {{ $paginator->nextPageUrl() }} @else javascript: void(0); @endif" aria-label="Next">
            <span aria-hidden="true">»</span>
            <span class="sr-only">Next</span>
        </a>
    </li>
</ul>
@endif