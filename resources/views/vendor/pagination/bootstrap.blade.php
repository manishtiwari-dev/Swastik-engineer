@if ($paginator->hasPages())
 
<ul class=" page-pagination text-center mt-3 none-style">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <a class="prev page-numbers" href="javascript:void(0)"><i class="flaticon-back"></i></a>
        </li>
    @else

        <li>
            <a class="prev page-numbers" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="flaticon-back"></i></a>
        </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
                @else
                    <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    
        <li>
            <a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="flaticon-right-arrow-1"></i></a>
        </li>

    @else
    
        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <a class="prev page-numbers"  href="javascript:void(0)"><i class="flaticon-right-arrow-1"></i></a>
        </li>

    @endif
</ul>
  
@endif
