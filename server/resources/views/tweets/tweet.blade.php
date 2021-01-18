<?php
    $auth = '';
    if (Session::get('auth')) $auth = Session::get('auth');

    $avatar = '';
    if($tweet->avatar) $avatar = '/storage/media/'.$tweet->user_id.'/avatar/thumbnail.'.$tweet->avatar;

    // add links in tweet
    $str = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a class="link a" href="/home/hashtag/$1?page=1">#$1</a>', $tweet->text);
    $str = preg_replace('/(?<!\S)@([0-9a-zA-Z_-]+)/', '<a class="link a" href="/profile/tweets/$1">@$1</a>', $str);
    $str = preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', '$1 <a target="_blank" href="$2">$3</a>', $str);
?>
<div class="tweet tweet-{{$tweet->id}}" id="tweet-{{$tweet->id}}" onclick="tweetDetailsDialog.open(event, {{$tweet}})">
    <!-- pinned -->
    <div class="pinned {{$tweet->is_pinned ? 'is-pinned' : ''}}">
        <i class="fa fa-thumbtack"></i> Pinned tweet
    </div>
    <!-- retweeted username -->
    @if ($tweet->retweeted_username)
        <a class="retweeted a" href={{'/profile/tweets/'.$tweet->retweeted_username}}>
            <i class="fa fa-retweet"></i> {{'@'.$tweet->retweeted_username}} retweeted
        </a>
    @endif
    <!-- replying to -->
    @if (!empty($tweet->replying_to))
        <div class="replying-to" onclick="tweetDetailsDialog.openForReplyingTo(event, {{$tweet->reply_to}})">
            <span class="replying">
                Replying to {{'@'.$tweet->replying_to}}
            </span>
        </div>
    @endif
    <!-- avatar -->
    <a class="avatar a" href={{'/profile/tweets/'.$tweet->username}}>
        @if(isset($tweet->avatar))
            <img class="avatarImg a" src={{$avatar}} />
        @else
            <i class="fa fa-user"></i>
        @endif
    </a>
    <!-- header -->
    <div class="info">
        <!-- fullname -->
        <span class="fullname">{{$tweet->fullname}}</span>
        <!-- username -->
        <span class="username">
            <a class="a" href={{'/profile/tweets/'.$tweet->username}}>{{'@'.$tweet->username}}</a>
        </span>
        <!-- date -->
        <span class="date"></span>
        <!-- menu -->
        <div class="toggle a" onclick="tweetEvents.openTweetMenu(this)">
        @if(!$tweet->retweetedBy)
            <i class="fa fa-angle-down"></i>
            @include('tweets.tweet_menu', ['tweet' => $tweet])
        @endif
        </div>
    </div>
    <!-- text -->
    <div class="text">
        <p><?php echo htmlspecialchars_decode($str); ?></p>
    </div>
    <!-- footer -->
    <div class="icons">
        <!-- reply icon -->
        <div class="reply-icon a" onclick="tweetDialog.open({{$tweet}})">
            <i class="fa fa-comment-o"></i>
            <span class="span">{{$tweet->num_replies ? $tweet->num_replies : 0}}</span>
        </div>
        <!-- retweet icon -->
        <div class="retweet-icon a {{ $tweet->is_retweeted ? 'active' : '' }}"
            onclick="tweetEvents.postRetweet('{{$tweet->id}}')">
            <i class="fa fa-retweet"></i>
            <span class="span">{{$tweet->num_retweets ? $tweet->num_retweets : 0}}</span>
        </div>
        <!-- like icon -->
        <div class="like-icon a {{ $tweet->is_liked ? 'active' : '' }}"
            onclick="tweetEvents.postLike('{{$tweet->id}}')">
            <i class="fa {{ $tweet->is_liked ? 'fa-heart' : 'fa-heart-o' }}"></i>
            <span class="span">{{$tweet->num_likes ? $tweet->num_likes : 0}}</span>
        </div>
        <!-- chart icon -->
        <div class="chart-icon a">
            <i class="fa fa-bar-chart"></i>
        </div>
    </div>
    <script>
        var tweetId = <?php echo $tweet->id ?>;
        var tweetTime = <?php echo '"' . $tweet->time . '"' ?>;
        var date = moment.utc(tweetTime).utcOffset(timezoneOffset).format('MMM Do, YYYY');
        if (window.innerWidth > 960) {
            $('.tweet-' + tweetId).find('.date').html(' · ' + date);
        } else {
            $('.tweet-' + tweetId).find('.date').html('<br />' + date);
        }
    </script>
</div>

@include('tweets/tweet_style')
