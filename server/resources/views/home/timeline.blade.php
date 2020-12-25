<?php
    $p = $pagination;
?>
<div class='timeline'>
    <?php if(isset($tweets)) : ?>
        <ul>
        <?php foreach($tweets as $t) : ?>
            <li>
            @include('tweets/tweet', ['tweet' => $t])
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <!-- pagination -->
    <div style="text-align: right">
        <ul class="pagination">
            <!-- previous button -->
            <li class="page-item {{ $p->current_page <= 1 ? 'disabled' : '' }}">
                @if ($p->current_page <= 1)
                    <span class="page-link">Previous</span>
                @else
                    <a class="page-link" href="{{ '/home?page=' . ($p->current_page - 1) }}">Previous</a>
                @endif
            </li>
            <!-- page items -->
            @for ($i = 1; $i <= ($p->total / $p->per_page) + 1; $i++)
                <li class="page-item {{ $p->current_page == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ '/home?page=' . $i }}">{{ $i }}</a>
                </li>
            @endfor
            <!-- next button -->
            <li class="page-item {{ $p->current_page >= ($p->total / $p->per_page) ? 'disabled' : '' }}">
                @if ($p->current_page >= ($p->total / $p->per_page))
                    <span class="page-link">Next</span>
                @else
                    <a class="page-link" href="{{ '/home?page=' . ($p->current_page + 1) }}">Next</a>
                @endif
            </li>
        </ul>
    </div>
</div>

@include('tweets/tweet_functions')
@include('home/timeline_style')
@include('tweets/tweet_style')
