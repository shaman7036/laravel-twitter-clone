<?php
    $avatar = '';
    $msg = '';

    if(Session::get('auth')) {
        $auth = Session::get('auth');
        if($auth->avatar) $avatar = '/storage/media/'.$auth->id.'/avatar/thumbnail.'.$auth->avatar;
    }
?>
<div class='tweet-dialog dialog animated fadeIn' onclick='tweetDialog.close(event)'>
    <form class="wrapper modal-content animated fadeInUp" method="POST" action="/tweets">
        {{ csrf_field() }}
        <!-- header -->
        <div class="modal-header">
            <h3>Compose new Tweet</h3>
            <i class="fa fa-times close-dialog" onclick="tweetDialog.close(event)"></i>
        </div>
        <!-- target tweet -->
        <div class="target"></div>
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
                    class="form-control" type="text" name="text"
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
$('.tweet-dialog .tweet-dom').removeClass('default');

const tweetDialog = {
    open: (target) => {
        // set default
        const dialog = $('.tweet-dialog');
        dialog.find('h3').html('Compose new Tweet');
        dialog.find('form').attr('action', '/tweets');
        dialog.find('textarea').val('');
        dialog.find('textarea').attr('placeholder', 'What\'s happening?');
        dialog.find('.tweet-button').removeClass('active');
        dialog.find('.tweet-button').val('Tweet');

        // open dialog
        if(auth && auth.username) {
            $('.dialog').hide();
            $('.tweet-dialog').show();
        } else {
            window.location.href = '/';
        }
        $('.tweet-dialog textarea').focus();

        // set target for replying
        if(target) {
            dialog.find('h3').html('Replying to @' + target.username);
            dialog.find('form').attr('action', '/replies');
            dialog.find('textarea').attr('placeholder', 'Tweet your reply');
            dialog.find('.tweet-button').val('Reply');
            $('.tweet-dialog .target').html('');
            tweetDOM.appendTo('.tweet-dialog .target', target);
            $('.tweet-dialog .tweet-dom-'+target.id).find('input.reply-to').val(target.id);
        }
    },

    close: (e) => {
        e.stopPropagation();
        var list = e.target.classList.toString();
        if(list.indexOf('tweet-dialog') > -1 || list.indexOf('close-dialog') > -1) {
            $('.tweet-dialog .target').html('');
            $('.tweet-dialog').hide();
        }
    },

    onKeyUp: (e) => {
        var len = e.target.value.length;
        if(len > 1) $('.tweet-button').addClass('active');
        else $('.tweet-button').removeClass('active');
    },
};
</script>

@include('dialogs/tweet_dialog_style')
