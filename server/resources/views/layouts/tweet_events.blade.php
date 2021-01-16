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
            error: () => {
                if (!icon.hasClass('active')) {
                    // back to be liked
                    numLikes++;
                    icon.find('i').addClass('fa-heart');
                    icon.find('i').removeClass('fa-heart-o');
                } else {
                    // backt not to be liked
                    if (numLikes > 0) numLikes--;
                    icon.find('i').removeClass('fa-heart');
                    icon.find('i').addClass('fa-heart-o');
                }
                tweet.find('.like-icon span').html(numLikes);
                checkActivity(icon);
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
            error: () => {
                if (!icon.hasClass('active')) {
                    // back to be retweeted
                    numRetweets++;
                } else if (numRetweets > 0) {
                    // back not to be retweeted
                    numRetweets--;
                }
                tweet.find('.retweet-icon span').html(numRetweets);
                checkActivity(icon);
            },
            complete: () => icon.removeClass('requesting'),
        });
    },

    pinTweet: (tweetId) => {
        if(!auth) {
            window.location.href = '/login';
            return;
        }
        const visibleStyle = { 'padding-top': '7.5px', 'height': '100%', 'opacity': '1' };
        const invisibleStyle = { 'padding-top': '0px', 'height': '0px', 'opacity': '0' }
        const target = $('.tweet-' + tweetId);
        if ((auth && window.location.href.indexOf('/profile/tweets/' + auth.username) > -1) ||
            (auth && window.location.href.indexOf('/profile/with_replies/' + auth.username) > -1)) {
            target.animate({ 'padding-top': '0px', 'height': '0px', 'opacity': '0' }, 'fast', 'linear', () => {
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
                        target.animate(visibleStyle, 'normal', 'linear', () => {
                            pinnedTweets.addClass('active');
                            // unpin the oldest pinnded tweet if the number of pins has been exceeded
                            if (res.unpinnedTweetId) {
                                const unpinnedTweet = pinnedTweets.find('.tweet-' + res.unpinnedTweetId);
                                unpinnedTweet.animate(invisibleStyle, 'fast', 'linear', () => {
                                    unpinnedTweet.appendTo('.profile .unpinned-tweets');
                                    unpinnedTweet.animate(visibleStyle, 'fast', 'linear');
                                    unpinnedTweet.find('.pinned').removeClass('is-pinned');
                                    unpinnedTweet.find('.menu-item-pin').removeClass('is-pinned');
                                });
                            }
                        });
                    } else {
                        // unpinned
                        target.show();
                        target.find('.pinned').removeClass('is-pinned');
                        target.find('.menu-item-pin').removeClass('is-pinned');
                        target.appendTo('.profile .unpinned-tweets');
                        target.animate(visibleStyle, 'fast', 'linear', () => {
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
                        // unpin the oldest pinnded tweet if the number of pins has been exceeded
                        if (res.unpinnedTweetId) {
                            const unpinnedTweet = $('.tweet-' + res.unpinnedTweetId);
                            if (unpinnedTweet) {
                                unpinnedTweet.find('.pinned').removeClass('is-pinned');
                                unpinnedTweet.find('.menu-item-pin').removeClass('is-pinned');
                            }
                        }
                    } else {
                        // unpinned
                        target.find('.pinned').removeClass('is-pinned');
                        target.find('.menu-item-pin').removeClass('is-pinned');
                    }
                }
            },
            error: () => {
                target.show();
                target.css(visibleStyle);
            },
        });
    },
}
</script>
