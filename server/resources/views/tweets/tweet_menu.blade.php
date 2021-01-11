<?php
    $delete = true;
?>
<div class="tweet-menu" id="tweet-menu-{{$tweet->id}}" style="display: none">
    <div><div></div></div>
    <ul>
        <li class="menu-item pin-tweet" onclick="tweetEvents.pinTweet({{$tweet->id}})"></li>
        <li class="menu-item">Report Tweet</li>
        @if($delete)
            <li class="menu-item" onclick="deleteDialog.open({{$tweet}})">Delete Tweet</li>
        @endif
    </ul>
</div>

@include('tweets/tweet_menu_style')
