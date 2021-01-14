<script>
const tweetEvents = {
    openTweetMenu(tweet) {
        var menu = tweet.children[1];
        if(menu.style.display === 'none') menu.style.display = 'inline-block';
        else menu.style.display = 'none';
    },

    postLike: (tweetId) => {
        if(!auth) {
            window.location.href = '/login';
            return;
        }
        const tweet = $('.tweet-'+tweetId);
        const icon = tweet.find('.like-icon');
        if (icon.hasClass('requesting')) return;
        icon.addClass('requesting');
        var numLikes = tweet.find('.like-icon span').html();
        if (!numLikes) numLikes = 0;
        if (!icon.hasClass('active')) {
            // like
            numLikes++;
            icon.find('i').addClass('fa-heart');
            icon.find('i').removeClass('fa-heart-o');
        } else {
            // unlike
            if (numLikes > 0) numLikes--;
            icon.find('i').removeClass('fa-heart');
            icon.find('i').addClass('fa-heart-o');
        }
        tweet.find('.like-icon span').html(numLikes);
        checkActivity(icon);
        $.ajax({
            type: 'POST',
            url: '/likes',
            data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
            success: (res) => {
                if (res.isLiked) {
                    // liked
                    icon.addClass('active');
                    icon.find('i').addClass('fa-heart');
                    icon.find('i').removeClass('fa-heart-o');
                } else {
                    // unliked
                    icon.removeClass('active');
                    icon.find('i').removeClass('fa-heart');
                    icon.find('i').addClass('fa-heart-o');
                }
            },
            complete: () => icon.removeClass('requesting'),
        });
    },

    postRetweet: (tweetId) => {
        if(!auth) {
            window.location.href = '/login';
            return;
        }
        const tweet = $('.tweet-'+tweetId);
        const icon = tweet.find('.retweet-icon');
        if (icon.hasClass('requesting')) return;
        icon.addClass('requesting');
        var numRetweets = tweet.find('.retweet-icon span').html();
        if (!numRetweets) numRetweets = 0;
        if (!icon.hasClass('active')) {
            // retweet
            numRetweets++;
        } else if (numRetweets > 0) {
            // unretweet
            numRetweets--;
        }
        tweet.find('.retweet-icon span').html(numRetweets);
        checkActivity(icon);
        $.ajax({
            type: 'POST',
            url: '/retweets',
            data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
            success: (res) => {
                if (res.isRetweeted) {
                    // retweeted
                    tweet.find('.retweet-icon i').addClass('active');
                    icon.addClass('active');
                } else {
                    // unretweeted
                    icon.removeClass('active');
                }
            },
            complete: () => icon.removeClass('requesting'),
        });
    },

    pinTweet: (tweetId) => {
        if(!auth) {
            window.location.href = '/login';
            return;
        }
        const target = $('.tweet-' + tweetId);
        if ((auth && window.location.href.indexOf('/profile/tweets/' + auth.username) > -1) ||
            (auth && window.location.href.indexOf('/profile/with_replies/' + auth.username) > -1)) {
            target.animate({ height: '0px', opacity: '0' }, 'fast', () => {
                target.hide();
            });
        }
        $.ajax({
            type: 'POST',
            url: '/pins',
            data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
            success: (res) => {
                if ((auth && window.location.href.indexOf('/profile/tweets/' + auth.username) > -1) ||
                    (auth && window.location.href.indexOf('/profile/with_replies/' + auth.username) > -1)) {
                    // response for auth profile
                    const pinnedTweets = $('.profile .pinned-tweets');
                    if (res.isPinned) {
                        // pinned
                        target.show();
                        target.find('.pinned').addClass('is-pinned');
                        target.find('.menu-item-pin').addClass('is-pinned');
                        target.prependTo('.profile .pinned-tweets');
                        target.animate({ height: '100%', opacity: '1' }, 'fast', () => {
                            pinnedTweets.addClass('active');
                        });
                    } else {
                        // unpinned
                        target.show();
                        target.find('.pinned').removeClass('is-pinned');
                        target.find('.menu-item-pin').removeClass('is-pinned');
                        target.appendTo('.profile .unpinned-tweets');
                        target.animate({ height: '100%', opacity: '1' }, 'fast', () => {
                            if (pinnedTweets.find('.tweet').length === 0) {
                                pinnedTweets.removeClass('active');
                            }
                        });
                    }
                } else {
                    // response for home or non auth profiles
                    if (res.isPinned) {
                        // pinned
                        target.find('.pinned').addClass('is-pinned');
                        target.find('.menu-item-pin').addClass('is-pinned');
                    } else {
                        // unpinned
                        target.find('.pinned').removeClass('is-pinned');
                        target.find('.menu-item-pin').removeClass('is-pinned');
                    }
                }
            },
            error: () => {
                target.show();
                target.css({ 'height': '100%', 'opacity': '1' });
            },
        });
    },
}
</script>
