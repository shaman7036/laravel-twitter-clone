<div class='tweet-details-dialog animated fadeIn' onclick='tweetDetailsDialog.close(event)'>
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
            <div class="target">
                @include('tweets.tweet_dom')
                <!-- links -->
                <div class="links">
                    <!-- link to user list of retweets -->
                    <div class="retweets"></div>
                    <!-- link to user list of likes -->
                    <div class="likes"></div>
                </div>
            </div>
            <!-- replies -->
            <div class="replies">
            </div>
        </div>
        <!-- footer -->
        <div class="modal-footer"></div>
    </form>
</div>

<script>
const tweetDetailsDialog = {
    open(e, tweet) {
        cl = e.target.classList.toString();
        if (cl.indexOf('a') > -1 || cl.indexOf('fa') > -1 || cl.indexOf('menu-item') > -1) {
            return;
        }
        $('.tweet-details-dialog').show();

        // set data to target tweet
        const target = $('.tweet-details-dialog .target .tweet-dom');
        target.show();
        target.addClass('tweet-dom-'+tweet.id);
        tweetDOM.setData(tweet);

        // set retweets and likes
        $('.target .links .retweets').html(tweet.num_retweets + ' <span>Retweets</span>');
        $('.target .links .likes').html(tweet.num_likes + ' <span>Likes</span>');
    },

    close: (e) => {
        e.stopPropagation();
        var list = e.target.classList.toString();
        if(list.indexOf('tweet-details-dialog') > -1 || list.indexOf('close-dialog') > -1) {
            $('.tweet-details-dialog').hide();
        }
    },
}
</script>

@include('dialogs.tweet_details_dialog_style')
