<?php
    $arr = array();
    foreach($tweets as $t) {
        array_push($arr, $t);
    }
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
</div>

@include('tweets/tweet_functions')
<script>
var tweets = <?php echo json_encode($arr); ?>;
</script>

@include('home/timeline_style')
@include('tweets/tweet_style')
