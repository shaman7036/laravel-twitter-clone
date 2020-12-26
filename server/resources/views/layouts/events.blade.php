<script>
// tweet events
const tweetEvents = {
    openMenu: (t) => {
        var menu = t.children[1];
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
        if (!icon.hasClass('active')) {
            // like
            icon.addClass('active');
            icon.find('i').addClass('fa-heart');
            icon.find('i').removeClass('fa-heart-o');
        } else {
            // unlike
            icon.removeClass('active');
            icon.find('i').removeClass('fa-heart');
            icon.find('i').addClass('fa-heart-o');
        }
        $.ajax({
            type: 'POST',
            url: '/likes',
            data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
            success: function(res) {
                if(res.success) {
                    var numLikes = tweet.find('.like-icon span').html();
                    if (!numLikes) numLikes = 0;
                    if (res.isLiked) {
                        // liked
                        numLikes++;
                        icon.addClass('active');
                        icon.find('i').addClass('fa-heart');
                        icon.find('i').removeClass('fa-heart-o');
                    } else {
                        // unliked
                        if (numLikes > 0) numLikes--;
                        icon.removeClass('active');
                        icon.find('i').removeClass('fa-heart');
                        icon.find('i').addClass('fa-heart-o');
                    }
                    tweet.find('.like-icon span').html(numLikes);
                }
            }
        });
    },

    postRetweet: (tweetId) => {
        if(!auth) {
            window.location.href = '/login';
            return;
        }
        const tweet = $('.tweet-'+tweetId);
        const icon = tweet.find('.retweet-icon');
        if (!icon.hasClass('active')) {
            // retweet
            icon.addClass('active');
        } else {
            // unretweet
            icon.removeClass('active');
        }
        $.ajax({
            type: 'POST',
            url: '/retweets',
            data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
            success: function(res) {
                if(res.success) {
                    var numRetweets = tweet.find('.retweet-icon span').html();
                    if (!numRetweets) numRetweets = 0;
                    if (res.isRetweeted) {
                        // retweeted
                        numRetweets++;
                        tweet.find('.retweet-icon i').addClass('active');
                        icon.addClass('active');
                    } else {
                        // unretweeted
                        if (numRetweets > 0) numRetweets--;
                        icon.removeClass('active');
                    }
                    tweet.find('.retweet-icon span').html(numRetweets);
                }
            }
        });
    }
}

// follow events
const followEvents = {
    followProfile: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('.profile .follow');
        if (!button.hasClass('active')) {
            // follow
            button.addClass('active');
        } else {
            // unfollow
            button.removeClass('active');
        }
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                numFollowers = $('.profile-followers').html();
                if (res.isFollowed) {
                    // followed
                    $('.profile .follow').addClass('active');
                    numFollowers++;
                } else {
                    // unfollowed
                    $('.profile .follow').removeClass('');
                    if (numFollowers > 0) numFollowers--;
                }
                $('.profile-followers').html(numFollowers);
            }
        });
    },

    followUserInProfile: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('#user-' + userId + ' .user-follow-button');
        if (!button.hasClass('active')) {
            // follow
            button.addClass('active');
        } else {
            // unfollow
            button.removeClass('active');
        }
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                if (res.isFollowed) {
                    // followed
                    button.addClass('active');
                } else {
                    // unfollowed
                    button.removeClass('active');
                }
            }
        });
    },

    followUserInHome: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('#right-user-' + userId + ' .follow-button');
        if (!button.hasClass('active')) {
            // follow
            button.addClass('active');
        } else {
            // unfollow
            button.removeClass('active');
        }
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                let numFollowing = $('.home .num-following').html();
                if (res.isFollowed) {
                    // followed
                    button.addClass('active');
                    numFollowing++;
                } else {
                    // unfollowed
                    button.removeClass('active');
                    if(numFollowing > 0) {
                        numFollowing--;
                    }
                }
                $('.home .num-following').html(numFollowing);
            }
        });
    },
};
</script>
