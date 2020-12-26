<?php
    $auth = '';
    if (Session::get('auth')) $auth = Session::get('auth');

    $avatar = '';
    if($tweet->avatar) $avatar = '/storage/media/'.$tweet->user_id.'/avatar/thumbnail.'.$tweet->avatar;

    // add links in tweet
    $str = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a class="link" href="/hashtag/$1">#$1</a>', $tweet->text);
    $str = preg_replace('/(?<!\S)@([0-9a-zA-Z_-]+)/', '<a class="link" href="/profile/tweets/$1">@$1</a>', $str);
    $str = preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$3</a>', $str);
    ?>
    <div class="{{'tweet tweet-'.$tweet->id}}" username={{$tweet->username}}>
    @if($tweet->retweeted_username)
        <a class="retweeted" href={{'/profile/tweets/'.$tweet->retweeted_username}}>
            <i class="fa fa-retweet"></i> {{'@'.$tweet->retweeted_username}} retweeted
        </a>
    @endif
    {{-- @if(isset($replyTo->username))
        <div class='replyingTo replying'>
        <span class='replying' onclick='open_replied(event, "{{$replyTo->id}}")'>
            Replying to {{'@'.$replyTo->username}}
        </span>
        </div>
    @endif --}}
    <!-- avatar -->
    <a class='avatar' href={{'/profile/tweets/'.$tweet->username}}>
        @if(isset($tweet->avatar))
        <img class='avatarImg' src={{$avatar}} onerror="this.style.display='none'" />
        @else
        <i class='fa fa-user'></i>
        @endif
    </a>
    <!-- header -->
    <div class='info'>
        <!-- fullname -->
        <span class='fullname'>{{$tweet->fullname}}</span>
        <!-- username -->
        <span class='username'>
        <a href={{'/profile/tweets/'.$tweet->username}}>{{'@'.$tweet->username}}</a>
        </span>
        <!-- date -->
        <span class='date'>・</span>
        <!-- menu -->
        <div class='toggle' onclick='openMenu(this)'>
        @if(!$tweet->retweetedBy)
            <i class='fa fa-angle-down'></i>
            @include('tweets.tweet_menu', ['id' => 'tweetMenu-'.$tweet->id, 'tweetId' => $tweet->id])
        @endif
        </div>
    </div>
    <!-- text -->
    <div class='content' onclick='openReplies(event, "{{$tweet->id}}")'>
        <p><?php echo htmlspecialchars_decode($str); ?></p>
    </div>
    <!-- footer -->
    <div class='icons'>
        <!-- reply icon -->
        <div class="reply-icon" onclick="openReplyDialog('{{$tweet->id}}'')">
            <i class='fa fa-comment-o'></i>
            <span class="span">{{$tweet->num_replies ? $tweet->num_replies : 0}}</span>
        </div>
        <!-- retweet icon -->
        <div class="retweet-icon {{ $tweet->is_retweeted ? 'active' : '' }}" onclick="postRetweet('{{$tweet->id}}')">
            <i class="fa fa-retweet"></i>
            <span class="span">{{$tweet->num_retweets ? $tweet->num_retweets : 0}}</span>
        </div>
        <!-- like icon -->
        <div class="like-icon {{ $tweet->is_liked ? 'active' : '' }}" onclick="postLike('{{$tweet->id}}')">
            <i class="fa {{ $tweet->is_liked ? 'fa-heart' : 'fa-heart-o' }}"></i>
            <span class='span'>{{$tweet->num_likes ? $tweet->num_likes : 0}}</span>
        </div>
        <!-- chart icon -->
        <div class='chart-icon'>
            <i class='fa fa-bar-chart'></i>
        </div>
    </div>
    <script>
        var tweet = <?php echo $tweet; ?>;
        var date = moment(tweet.time).format('MMM Do YYYY, HH:mm:ss');
        $('.tweet-'+tweet.id).find('.date').html('・'+date);
    </script>
</div>

@include('tweets/tweet_style')
