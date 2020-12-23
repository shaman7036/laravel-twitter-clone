<script>
function openMenu(t) {
    var menu = t.children[1];
    if(menu.style.display === 'none') menu.style.display = 'inline-block';
    else menu.style.display = 'none';
}

function postLike(tweetId) {
    if(!auth) {
        window.location.href = '/login';
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/likes',
        data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
        success: function(res) {
            if(res.success) {
                var tweet = $('.tweet-'+tweetId);
                var numLikes = tweet.find('.like-icon span').html();
                if (!numLikes) numLikes = 0;
                if (res.isLiked) {
                    numLikes++;
                    tweet.find('.like-icon i').addClass('active');
                } else if(!res.isLiked && numLikes > 0) {
                    numLikes--;
                    tweet.find('.like-icon i').removeClass('active');
                }
                tweet.find('.like-icon span').html(numLikes);
            }
        }
    });
}

function postRetweet(tweetId) {
    if(!auth) {
        window.location.href = '/login';
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/retweets',
        data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
        success: function(res) {
            if(res.success) {
                var tweet = $('.tweet-'+tweetId);
                var numRetweets = tweet.find('.retweet-icon span').html();
                if (!numRetweets) numRetweets = 0;
                if (res.isRetweeted) {
                    numRetweets++;
                    tweet.find('.retweet-icon i').addClass('active');
                } else if(!res.isRetweeted && numRetweets > 0) {
                    numRetweets--;
                    tweet.find('.retweet-icon i').removeClass('active');
                }
                tweet.find('.retweet-icon span').html(numRetweets);
            }
        }
    });
}
</script>
