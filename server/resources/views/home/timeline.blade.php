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
    <!-- back to top -->
    <div class="footer" onclick="backToTop()">
        <span>Back to Top</span>
    </div>
    <!-- pagination -->
    @include('layouts.pagination', ['pagination' => $pagination])
</div>

@include('home/timeline_style')
@include('tweets/tweet_style')
