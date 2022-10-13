@if ($paginator->hasPages())
    <div class="center-align">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a href="#" class="btn" disabled><i class="material-icons">first_page</i></a>
                <a href="#" class="btn" disabled><i class="material-icons">chevron_left</i></a>
            @else
            <a href="{{ $paginator->toArray()['first_page_url'] }}" class="btn tooltipped" data-tooltip="First Page" data-position="top"><i class="material-icons">first_page</i></a>
            <a href="{{ $paginator->previousPageUrl() }}" class="btn tooltipped" data-tooltip="Previous Page" data-position="top"><i class="material-icons">chevron_left</i></a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn tooltipped" data-tooltip="Next Page" data-position="top"><i class="material-icons">chevron_right</i></a>
            <a href="{{ $paginator->toArray()['last_page_url'] }}" class="btn tooltipped" data-tooltip="Last Page" data-position="top"><i class="material-icons">last_page</i></a>
            @else
            <a href="#" class="btn disabled"><i class="material-icons">chevron_right</i></a>
            <a href="#" class="btn disabled"><i class="material-icons">last_page</i></a>
            @endif
        <p style="margin-top: 15px;">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}        </p>
    </div>
@endif
