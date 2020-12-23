<script>
function openMenu(t) {
    var menu = t.children[1];
    if(menu.style.display === 'none') menu.style.display = 'inline-block';
    else menu.style.display = 'none';
}

function postLike(tweetId) {
    if(!auth) {
        window.location.href = '/logIn';
        return;
    }

    $.ajax({
        url: '/likes',
        type: 'POST',
        data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
        success: function(res) {
            console.log(JSON.stringify(res));
            if(res.success) {
                var tweet = $('.tweet-'+tweetId);
                var currentLikes = tweet.find('.like-icon span').html();
                if (!currentLikes) currentLikes = 0;
                if (res.isLiked) {
                    currentLikes++;
                    tweet.find('.like-icon i').addClass('active');
                } else if(!res.isLiked && currentLikes > 0) {
                    currentLikes--;
                    tweet.find('.like-icon i').removeClass('active');
                }
                tweet.find('.like-icon span').html(currentLikes);
            }
        }
    });
}

function postRetweet(id) {
    // console.log('post_retweet('+id+')');
    // var url = '/retweets';

    // if(!auth) {
    //     window.location.href = '/logIn';
    //     return;
    // }

    // $.ajax({
    //     url: url,
    //     type: 'POST',
    //     data: {"_token": "{{ csrf_token() }}", id: id},
    //     success: function(res) {
    //     console.log(JSON.stringify(res));
    //     if(res.success) {
    //         var tweet = $('.tweet-'+id);
    //         tweet.find('.retweetIcon span').html(res.tweetRetweets);
    //         if(res.retweeted) tweet.find('.retweetIcon i').addClass('active');
    //         else tweet.find('.retweetIcon i').removeClass('active');
    //     }
    //     }
    // });
}
</script>
