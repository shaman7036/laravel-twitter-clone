<?php
    $avatar = '';
    $msg = '';

    if(Session::get('auth')) {
        $auth = Session::get('auth');
        if($auth->avatar) $avatar = '/storage/media/'.$auth->id.'/avatar/thumbnail.'.$auth->avatar;
    }
?>
<div class='tweet-dialog animated fadeIn' onclick='tweetDialog.closeTweetDialog(event)'>
    <form class='wrapper modal-content animated fadeInUp' method='POST' action='/tweets'>
        {{ csrf_field() }}
        <div class='modal-header'>
            <h3>Compose new Tweet</h3>
            <i class='fa fa-times close-dialog' onclick='tweetDialog.closeTweetDialog(event)'></i>
        </div>
        <div class='modal-body'>
            <div class='avatar'>
                @if($avatar)
                    <img src={{$avatar}} />
                @else
                    <i class='fa fa-user'></i>
                @endif
            </div>
            <!-- tweet -->
            <div class='textarea'>
                <textarea
                    class='form-control' type='text' name='text' placeholder="What's happening?"
                    onkeyup='tweetDialog.onKeyUp(event)'>
                </textarea>
            </div>
        </div>
        <div class='modal-footer'>
            {{$msg}}
            <div>
                <ul class='icons'>
                    <li><i class='fa fa-image'></i></li>
                    <li><i class='fa fa-camera'></i></li>
                    <li><i class='fa fa-map-o'></i></li>
                    <li><i class='fa fa-map-marker'></i></li>
                </ul>
                <!-- submit button -->
                <input id='tweet-button' class='button btn btn-primary tweet-button' type='submit' value='Tweet' />
                <button class='button btn btn-default add-button'><i class='fa fa-plus'></i></button>
            </div>
        </div>
    </form>
</div>
<script>
var tweetDialog = {
    openTweetDialog: () => {
        $('.tweet-button').removeClass('active');
        $('.tweet-dialog textarea').val('');
        if(auth && auth.username) {
            $('.tweet-dialog').toggle();
        } else {
            window.location.href = '/';
        }
        $('.tweet-dialog textarea').focus();
    },

    closeTweetDialog: (e) => {
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
    }
};
</script>

@include('dialogs/tweet_dialog_style')
