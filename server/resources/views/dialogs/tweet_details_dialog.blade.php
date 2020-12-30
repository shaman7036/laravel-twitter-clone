<div class='tweet-details-dialog dialog animated fadeIn' onclick='tweetDetailsDialog.close(event)'>
    <form class="wrapper modal-content animated fadeInUp" method="POST" action="/tweets">
        {{ csrf_field() }}
        <!-- header -->
        <div class="modal-header">
            <h3>Tweet</h3>
            <i class="fa fa-times close-dialog"></i>
        </div>
        <!-- body -->
        <div class="modal-body" style="padding: 0px">
            <!-- target tweet -->
            <div class="target"></div>
            <!-- links -->
            <div class="links">
                <!-- number of replies -->
                <div class="num-replies"></div>
                <!-- link to user list of retweets -->
                <div class="num-retweets"></div>
                <!-- link to user list of likes -->
                <div class="num-likes"></div>
            </div>
            <!-- replies -->
            <div class="replies">
            </div>
        </div>
        <!-- footer -->
        <div class="modal-footer" onclick="tweetDetailsDialog.backToTop()">
            <span>Back to Top</span>
        </div>
    </form>
</div>

<script>
const tweetDetailsDialog = {
    maxHeight: 0.9, // 1.0 = window height

    open(e, tweet) {
        cl = e.target.classList.toString();
        if (cl.indexOf('a') > -1 || cl.indexOf('fa') > -1 || cl.indexOf('menu-item') > -1) {
            return;
        }
        const dialog = $('.tweet-details-dialog');
        $('.dialog').hide();
        dialog.show();

        // clear dialog's data
        this.clear();

        // set target tweet
        $('.tweet-details-dialog .target').empty();
        tweetDOM.appendTo('.tweet-details-dialog .target', tweet);

        // set numbers and events
        this.setNumbersAndEvents(tweet);

        // set max height and top
        const dh = dialog.height();
        dialog.find('.wrapper').css('max-height', dh * this.maxHeight);
        dialog.find('.wrapper').css('top', dh * (1 - this.maxHeight) / 2);

        // get replies
        dialog.find('.replies').empty();
        $.ajax({
            type: 'GET',
            url: '/replies?reply_to=' + tweet.id,
            data: {"_token": "{{ csrf_token() }}"},
            success: (res) => {
                if (res.replies) {
                    // set replies
                    res.replies.forEach(item => {
                        tweetDOM.appendTo('.tweet-details-dialog .replies', item);
                    });
                }
            },
        });
    },

    openForReplyingTo(e, replyTo) {
        e.stopPropagation();
        const dialog = $('.tweet-details-dialog');
        $('.dialog').hide();
        dialog.show();

        // clear dialog's data
        this.clear();

        // set max height and top
        const dh = dialog.height();
        dialog.find('.wrapper').css('max-height', dh * this.maxHeight);
        dialog.find('.wrapper').css('top', dh * (1 - this.maxHeight) / 2);

        // get target tweet and replies
        dialog.find('.replies').empty();
        $.ajax({
            type: 'GET',
            url: '/tweets/' + replyTo,
            data: {"_token": "{{ csrf_token() }}"},
            success: (res) => {
                // set target tweet
                const tweet = res.tweet;
                tweetDOM.appendTo('.tweet-details-dialog .target', tweet);
                // set numbers and events
                this.setNumbersAndEvents(tweet);
                if (res.replies) {
                    // set replies
                    res.replies.forEach(item => {
                        tweetDOM.appendTo('.tweet-details-dialog .replies', item);
                    });
                }
            },
            error: (err) => {
                console.log(err);
            },
        });
    },

    close(e) {
        e.stopPropagation();
        var list = e.target.classList.toString();
        if(list.indexOf('tweet-details-dialog') > -1 || list.indexOf('close-dialog') > -1) {
            this.clear();
            $('.tweet-details-dialog').hide();
        }
    },

    clear() {
        const dialog = $('.tweet-details-dialog');
        dialog.find('.target').empty();
        dialog.find('.links > *').empty();
        dialog.find('.links > *').unbind();
        dialog.find('.replies').empty();
    },

    setNumbersAndEvents(tweet) {
        const dialog = $('.tweet-details-dialog');
        dialog.find('.links > .num-replies').html((tweet.num_replies ? tweet.num_replies : 0) + ' <span>Replies</span>');
        dialog.find('.links > .num-retweets').html(tweet.num_retweets + ' <span>Retweets</span>');
        dialog.find('.links > .num-likes').html(tweet.num_likes + ' <span>Likes</span>');
        dialog.find('.links > .num-retweets').on('click', () => usersDialog.open('retweets', tweet.id));
        dialog.find('.links > .num-likes').on('click', () => usersDialog.open('likes', tweet.id));
    },

    backToTop() {
        $('.tweet-details-dialog .wrapper').stop().animate({ scrollTop: 0 }, 150);
    },
};
</script>

@include('dialogs.tweet_details_dialog_style')
