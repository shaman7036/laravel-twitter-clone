<?php
    $avatar = '';
    $msg = '';

    if(Session::get('auth')) {
        $auth = Session::get('auth');
        if($auth->avatar) $avatar = '/storage/media/'.$auth->id.'/avatar/thumbnail.'.$auth->avatar;
    }
?>
<div class='tweet-dialog animated fadeIn' onclick='tweetDialog.close(event)'>
    <form class="wrapper modal-content animated fadeInUp" method="POST" action="/tweets">
        {{ csrf_field() }}
        <!-- header -->
        <div class="modal-header">
            <h3>Compose new Tweet</h3>
            <i class="fa fa-times close-dialog" onclick="tweetDialog.close(event)"></i>
        </div>
        <!-- target tweet -->
        @include('tweets.target_tweet')
        <!-- body -->
        <div class="modal-body">
            <div class="avatar">
                @if($avatar)
                    <img src={{$avatar}} />
                @else
                    <i class="fa fa-user"></i>
                @endif
            </div>
            <!-- tweet -->
            <div class="textarea">
                <textarea
                    class="form-control" type="text" name="text" placeholder="What's happening?"
                    onkeyup="tweetDialog.onKeyUp(event)">
                </textarea>
            </div>
        </div>
        <!-- footer -->
        <div class="modal-footer">
            {{$msg}}
            <div>
                <!-- icons -->
                <ul class="icons">
                    <li><i class="fa fa-image"></i></li>
                    <li><i class="fa fa-camera"></i></li>
                    <li><i class="fa fa-map-o"></i></li>
                    <li><i class="fa fa-map-marker"></i></li>
                </ul>
                <!-- submit button -->
                <input id="tweet-button" class="button btn btn-primary tweet-button" type="submit" value="Tweet" />
                <button class="button btn btn-default add-button"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </form>
</div>
<script>
const tweetDialog = {
    open: (target) => {
        // set default
        const dialog = $('.tweet-dialog');
        dialog.find('h3').html('Compose new Tweet');
        dialog.find('form').attr('action', '/tweets');
        dialog.find('textarea').val('');
        dialog.find('.tweet-button').removeClass('active');
        dialog.find('.target-tweet').hide();
        dialog.find('.tweet-button').val('Tweet');

        // open dialog
        if(auth && auth.username) {
            $('.tweet-dialog').toggle();
        } else {
            window.location.href = '/';
        }
        $('.tweet-dialog textarea').focus();

        // set target for replying
        if(target) {
            const data = JSON.parse(target);
            tweetDialog.setTarget(data);
        }
    },

    close: (e) => {
        e.stopPropagation();
        var list = e.target.classList.toString();
        if(list.indexOf('tweet-dialog') > -1 || list.indexOf('close-dialog') > -1) {
            _('.tweet-dialog').style.display = 'none';
        }
    },

    onKeyUp: (e) => {
        var len = e.target.value.length;
        if(len > 1) $('.tweet-button').addClass('active');
        else $('.tweet-button').removeClass('active');
    },

    setTarget: (tweet) => {
        // change the dialog for replying
        const dialog = $('.tweet-dialog');
        dialog.find('h3').html('Replying to @' + tweet.username);
        dialog.find('form').attr('action', '/replies');
        dialog.find('.tweet-button').val('Reply');
        // show the target tweet
        const target = $('.tweet-dialog .target-tweet');
        target.show();
        // fix style in home
        if (window.location.href.indexOf('/home') > 0) {
            target.css('padding-bottom', '7.5px');
        }
        // id
        target.removeClass();
        target.addClass('target-tweet tweet tweet-' + tweet.id);
        target.find('input.reply-to').val(tweet.id);
        // avatar
        target.find('.avatar').attr('href', '/profile/tweets/' + tweet.username)
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
        // data
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
};
</script>

@include('dialogs/tweet_dialog_style')
