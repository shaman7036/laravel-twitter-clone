<script>
if (window.location.href.indexOf('/home') > -1) {
    $('.tweet').css('padding-bottom', '5px');
    $('.tweet-dom').find('.chart-icon').css('padding-top', '5px');
} else {
    $('.tweet').css('padding-bottom', '0px');
    $('.tweet-dom').find('.chart-icon').css('padding-top', '0px');
}

const tweetDOM = {
    appendTo: (parent, data) => {
        // clone and append
        $('.tweet-dom.default:first').clone().appendTo(parent);
        const clone = $(parent+' > .tweet-dom.default:first');
        clone.removeClass('default');
        clone.addClass('tweet-dom-' + data.id + ' tweet-' + data.id);
        // click event to open the tweet details dialog
        clone.on('click', (e) => {
            tweetDetailsDialog.open(e, data);
        });
        // replying to
        if (data.replying_to) {
            clone.find('.replying-to span').html('Replying to @' + data.replying_to);
            clone.find('.replying-to').on('click', (e) => {
                tweetDetailsDialog.openForReplyingTo(e, data.reply_to);
            });
        }
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
        const date = moment.utc(data.time).utcOffset(timezoneOffset).format('HH:mm A · MMM Do, YYYY');
        if (window.innerWidth > 960) {
            clone.find('.date').html(' · ' + date);
        } else {
            clone.find('.date').html('<br />' + date);
        }
        // text
        var str = data.text.replace(/(?<!\S)#([0-9a-zA-Z]+)/, '<a class="link a" href="/home/hashtag/$1?page=1">#$1</a>');
        str = str.replace(/(?<!\S)@([0-9a-zA-Z_-]+)/, '<a class="link a" href="/profile/tweets/$1">@$1</a>');
        var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
        str = str.replace(urlRegex, function(url) {
            return '<a target="_blank" href="' + url + '">' + url.replace(/(^\w+:|^)\/\//, '') + '</a>';
        });
        clone.find('.text p').html(str);
        // reply icon
        clone.find('.reply-icon span').html(data.num_replies ? data.num_replies : 0);
        clone.find('.reply-icon').on('click', function() {
            tweetDialog.open(data);
        });
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
