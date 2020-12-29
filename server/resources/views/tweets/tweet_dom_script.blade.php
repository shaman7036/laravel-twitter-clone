<script>
const tweetDOM = {
    appendTo(parent, data) {
        $('.tweet-dom.default:first').clone().appendTo(parent);
        const clone = $(parent+' > .tweet-dom.default:first');
        clone.removeClass('default');
        clone.addClass('tweet-dom-' + data.id + ' tweet-' + data.id);
        // avatar
        clone.find('.avatar').attr('href', '/profile/tweets/' + data.username);
        if (data.avatar) {
            const avatar = '/storage/media/' + data.user_id + '/avatar/thumbnail.' + data.avatar;
            clone.find('.avatar').html('<img class="avatarImg" src="'+ avatar +'" />');
        } else {
            clone.find('.avatar').html('<i class="fa fa-user"></i>');
        }
        // fullname
        clone.find('.fullname').html(data.fullname);
        // username
        clone.find('.username a').attr('href', '/profile/tweets/' + data.username);
        clone.find('.username a').html('@' + data.username);
        // date
        var date = moment(data.time).format('MMM Do YYYY, HH:mm:ss');
        clone.find('.date').html('・'+date);
        // text
        clone.find('.text p').html(data.text);
        // reply icon
        clone.find('.reply-icon span').html(data.num_replies ? data.num_replies : 0);
        // retweet icon
        const num_retweets = $('#tweet-' + data.id).find('.retweet-icon span').html();
        clone.find('.retweet-icon span').html(num_retweets ? num_retweets : 0);
        const is_retweeted = $('#tweet-' + data.id).find('.retweet-icon').hasClass('active');
        clone.find('.retweet-icon').removeClass('active');
        if (is_retweeted) {
            clone.find('.retweet-icon').addClass('active');
        }
        clone.find('.retweet-icon').click('click', () => {
            tweetEvents.postRetweet(data.id);
        });
        // like icon
        const num_likes = $('#tweet-' + data.id).find('.like-icon span').html();
        clone.find('.like-icon span').html(num_likes ? num_likes : 0);
        const is_liked = $('#tweet-' + data.id).find('.like-icon').hasClass('active');
        clone.find('.like-icon').removeClass('active');
        if (is_liked) {
            clone.find('.like-icon').addClass('active');
            clone.find('.like-icon i').addClass('fa-heart');
            clone.find('.like-icon i').removeClass('fa-heart-o');
        }
        clone.find('.like-icon').on('click', () => {
            tweetEvents.postLike(data.id);
        });
        clone.show();
    },
}
</script>
