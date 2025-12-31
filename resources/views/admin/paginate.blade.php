@if ($paginator->lastPage() > 1)
    <div class="row container justify-content-center mt-4">
        <div class="col-auto d-flex align-items-center gap-3">

            {{-- Prev Button --}}
            @if ($paginator->onFirstPage())
                <span class="btn btn-secondary disabled">← Prev</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-warning">← Prev</a>
            @endif

            {{-- Current Page Display --}}
            <span class="fw-semibold">
                Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
            </span>

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-warning">Next →</a>
            @else
                <span class="btn btn-secondary disabled">Next →</span>
            @endif

        </div>
    </div>
@endif
