<?php $p = $pagination; ?>
<div style="text-align: right">
    <ul class="pagination">
        <!-- previous button -->
        <li class="page-item {{ $p->current_page <= 1 ? 'disabled' : '' }}">
            @if ($p->current_page <= 1)
                <span class="page-link">Previous</span>
            @else
                <a class="page-link" href="{{ $p->page_link . '?page=' . ($p->current_page - 1) }}">Previous</a>
            @endif
        </li>
        <!-- page items -->
        @for ($i = 1; $i <= ($p->total / $p->per_page) + 1; $i++)
            <li class="page-item {{ $p->current_page == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $p->page_link . '?page=' . $i }}">{{ $i }}</a>
            </li>
        @endfor
        <!-- next button -->
        <li class="page-item {{ $p->current_page >= ($p->total / $p->per_page) ? 'disabled' : '' }}">
            @if ($p->current_page >= ($p->total / $p->per_page))
                <span class="page-link">Next</span>
            @else
                <a class="page-link" href="{{ $p->page_link . '?page=' . ($p->current_page + 1) }}">Next</a>
            @endif
        </li>
    </ul>
</div>
