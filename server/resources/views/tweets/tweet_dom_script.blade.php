<script>
const tweetDOM = {
    setData(tweet) {
        const target = $('.tweet-dom-' + tweet.id);
        target.removeClass('default');
        // id
        target.removeClass();
        target.addClass('tweet-dom tweet tweet-' + tweet.id);
        target.find('input.reply-to').val(tweet.id);
        // avatar
        target.find('.avatar').attr('href', '/profile/tweets/' + tweet.username);
        if (tweet.avatar) {
            tweet.avatar = '/storage/media/' + tweet.user_id + '/avatar/thumbnail.' + tweet.avatar;
            target.find('.avatar').html('<img class="avatarImg" src="'+ tweet.avatar +'" />');
        } else {
            target.find('.avatar').html('<i class="fa fa-user"></i>');
        }
        // fullname
        target.find('.fullname').html(tweet.fullname);
        // username
        target.find('.username a').attr('href', '/profile/tweets/' + tweet.username);
        target.find('.username a').html('@' + tweet.username);
        // date
        var date = moment(tweet.time).format('MMM Do YYYY, HH:mm:ss');
        target.find('.date').html('・'+date);
        // text
        target.find('.text p').html(tweet.text);
        // reply icon
        target.find('.reply-icon span').html(tweet.num_replies ? tweet.num_replies : 0);
        // retweet icon
        const num_retweets = $('#tweet-' + tweet.id).find('.retweet-icon span').html();
        target.find('.retweet-icon span').html(num_retweets ? num_retweets : 0);
        const is_retweeted = $('#tweet-' + tweet.id).find('.retweet-icon').hasClass('active');
        target.find('.retweet-icon').removeClass('active');
        if (is_retweeted) {
            target.find('.retweet-icon').addClass('active');
        }
        target.find('.retweet-icon').click('click', () => {
            tweetEvents.postRetweet(tweet.id);
        });
        // like icon
        const num_likes = $('#tweet-' + tweet.id).find('.like-icon span').html();
        target.find('.like-icon span').html(num_likes ? num_likes : 0);
        const is_liked = $('#tweet-' + tweet.id).find('.like-icon').hasClass('active');
        target.find('.like-icon').removeClass('active');
        if (is_liked) {
            target.find('.like-icon').addClass('active');
            target.find('.like-icon i').addClass('fa-heart');
            target.find('.like-icon i').removeClass('fa-heart-o');
        }
        target.find('.like-icon').on('click', () => {
            tweetEvents.postLike(tweet.id);
        });
    },
}
</script>
