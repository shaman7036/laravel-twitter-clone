<?php
    $auth = '';
    if (Session::get('auth')) $auth = Session::get('auth');
?>
<div class="tweets">
    <div class="header">
        <ul class="tweets_ul">
            <li class="li_tweets active" onclick="get_tweets()">
                <a href="{{ '/profile/tweets/' . $profile->username }}">Tweets</a>
            </li>
            <li class="li_replies" onclick="get_replies()">
                <a href="{{ '/profile/replies/' . $profile->username }}">Tweets & replies</a>
            </li>
            <li class="li_media" onclick="get_media()">
                <a href="{{ '/profile/media/' . $profile->username }}">Media</a>
            </li>
        </ul>
    </div>
    <div class="body">
        <ul>
        @foreach($tweets as $t)
            <li>@include('tweets/tweet', ['tweet' => $t])</li>
        @endforeach
        </ul>
    </div>
    <div class="footer" onclick="backToTop()">
        <span>Back to Top</span>
    </div>
</div>

@include('tweets/tweets_style')
