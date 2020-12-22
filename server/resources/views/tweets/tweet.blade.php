<?php
    $auth = '';
    if (Session::get('auth')) $auth = Session::get('auth');

    $avatar = '';
    if($tweet->avatar) $avatar = '/storage/media/'.$tweet->userId.'/avatar/thumbnail.'.$tweet->avatar;

    $retweeted = '';
    if ($tweet->retweeted === 1) $retweeted = 'active';

    $liked = '';
    if ($tweet->liked === 1) $liked = 'active';

    $replyTo = array();
    if($tweet->replyTo) $replyTo = json_decode($tweet->replyTo);

    // add links in tweet
    $str = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a class="link" href="/hashtag/$1">#$1</a>', $tweet->text);
    $str = preg_replace('/(?<!\S)@([0-9a-zA-Z_-]+)/', '<a class="link" href="/profile/tweets/$1">@$1</a>', $str);
    $str = preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$3</a>', $str);
    ?>
    <div class="{{'tweet tweet-'.$tweet->id}}" username={{$tweet->username}}>
    {{-- @if($tweet->retweetedBy)
        <div class='retweeted'>
        <i class='fa fa-retweet'></i> {{'@'.$tweet->retweetedBy}} retweeted
        </div>
    @endif
    @if(isset($replyTo->username))
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
        <div class='reply-icon' onclick='openReplyDialog("{{$tweet->id}}")'>
            <i class='fa fa-comment-o'></i>
            <span class='span'>{{$tweet->replies}}</span>
        </div>
        <!-- retweet icon -->
        <div class='retweet-icon' onclick='postRetweet("{{$tweet->id}}")'>
            <i class="{{'fa fa-retweet '.$retweeted}}"></i>
            <span class='span'>{{$tweet->retweets}}</span>
        </div>
        <!-- like icon -->
        <div class='like-icon' onclick='postLike("{{$tweet->id}}")'>
            <i class="{{'fa fa-heart-o '.$liked}}"></i>
            <span class='span'>{{$tweet->likes}}</span>
        </div>
        <!-- chart icon -->
        <div class='chart-icon'>
            <i class='fa fa-bar-chart'></i>
        </div>
    </div>
    <script>
        var tweet = <?php echo $tweet; ?>;
        var date = moment(tweet.created_at).format('MMM Do YYYY, HH:mm:ss');
        $('.tweet-'+tweet.id).find('.date').html('・'+date);
    </script>
</div>

@include('tweets/tweet_style')
