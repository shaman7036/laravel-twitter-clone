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
    @include('layouts.pagination', ['pagination' => $pagination, 'page_link' => '/home'])
</div>

@include('tweets/tweet_functions')
@include('home/timeline_style')
@include('tweets/tweet_style')
