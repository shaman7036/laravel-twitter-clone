<?php
    $delete = true;
?>
<div class='tweet-menu' id={{$id}} style="display: none">
    <div><div></div></div>
    <ul>
        <li class='menu-item'>Pin to your profile page</li>
        <li class='menu-item'>Report Tweet</li>
        @if($delete)
            <li class='menu-item' onclick='deleteDialog.open("{{$tweetId}}")'>Delete Tweet</li>
        @endif
    </ul>
</div>

@include('tweets/tweet_menu_style')
