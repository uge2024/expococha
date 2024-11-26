@if ($paginator->hasPages())
    <div class="pro-pagination-style text-center mtb-50px">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li  aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a href="#" class="btn disabled">
                        <i class="ion-ios-arrow-left"></i>
                    </a>
                </li>
            @else
                <li>
                    <a class="prev" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="ion-ios-arrow-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            {{--@foreach ($elements as $element)
                --}}{{-- "Three Dots" Separator --}}{{--
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                --}}{{-- Array Of Links --}}{{--
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach--}}

            <?php
                $start = $paginator->currentPage() - 1; // show 3 pagination links before current
                $end = $paginator->currentPage() + 1; // show 3 pagination links after current
                if($start < 1) {
                    $start = 1; // reset start to 1
                    $end += 1;
                }
                if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
            ?>

            @if($start > 1)
                <li>
                    <a href="{{ $paginator->url(1) }}">{{1}}</a>
                </li>
                @if($paginator->currentPage() != 4)
                    {{-- "Three Dots" Separator --}}
                    <li aria-disabled="true">
                        <a href="#" class="btn disabled">
                            ...
                        </a>
                    </li>
                @endif
            @endif
            @for ($i = $start; $i <= $end; $i++)
                <li>
                    <a class=" {{ ($paginator->currentPage() == $i) ? ' active' : '' }} " href="{{ $paginator->url($i) }}">{{$i}}</a>
                </li>
            @endfor
            @if($end < $paginator->lastPage())
                @if($paginator->currentPage() + 3 != $paginator->lastPage())
                    {{-- "Three Dots" Separator --}}
                    <li aria-disabled="true">
                        <a href="#" class="btn disabled">
                            ...
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ $paginator->url($paginator->lastPage()) }}">{{$paginator->lastPage()}}</a>
                </li>
            @endif


            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="ion-ios-arrow-right"></i>
                    </a>
                </li>
            @else
                <li aria-disabled="true" aria-label="@lang('pagination.next')">
                    <a href="#" class="btn disabled">
                        <i class="ion-ios-arrow-right"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
