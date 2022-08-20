<style>
    .custom-pagination {
        font-size: 1.2rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
    }

    .page-btn {
        height: 35px;
        width: 35px;
        border: 1px solid #bbb;
        border-radius:10px;
        background: #ccc;
        color: #333;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin-left: 4px;
        transition:.3s;
        user-select: none;
    }

    .arrows {
        transform: scale(.8);
        font-size: 1rem;
    }

    .custom-pagination a {
        color: #049e75;
        text-decoration: none;
    }

    .btn-active {
        border: 1px solid #222;
        background: #333;
        color: #ccc;
    }

    .btn-disabled {
        color: #777;
    }

    .page-btn:not(.btn-disabled,.arrows):hover {
        transform: scale(1.1);
    }

</style>


@if ($paginator->hasPages())
    <ul class="pagination custom-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-btn arrows btn-disabled"><span><i class="fas fa-angle-double-right"></i></span></li>
        @else
            <li class="page-btn arrows"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i
                        class="fas fa-angle-double-right"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-btn disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-btn btn-active"><span>{{ $page }}</span></li>
                    @else
                        <li class="page-btn"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-btn arrows"><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i
                        class="fas fa-angle-double-left"></i></a></li>
        @else
            <li class="page-btn arrows btn-disabled"><span><i class="fas fa-angle-double-left"></i></span></li>
        @endif
    </ul>
@endif
