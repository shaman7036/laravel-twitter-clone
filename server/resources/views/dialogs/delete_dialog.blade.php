<?php
    $authId = -1;
    if (Session::get('auth')) {
        $authId = Session::get('auth')->id;
        $authUsername = Session::get('auth')->username;
    }
?>
<div class="delete-dialog dialog animated fadeIn" id="deleteDialog" onclick="deleteDialog.close(event)">
    <div class="wrapper animated fadeInUp">
        <!-- header -->
        <div class="header">Delete tweet?</div>
        <!-- body -->
        <div class="body"></div>
        <!-- footer -->
        <div class="footer">
            <button class="button btn-danger delete-button" onclick="deleteDialog.deleteTweet()">Delete</button>
            <button class="button btn btn-default close-button" onclick="deleteDialog.close()">Cancel</button>
        </div>
    </div>
</div>

<script>
var authId = "<?php echo isset($authId) ? $authId : ''; ?>";
var authUsername = "<?php echo isset($authUsername) ? $authUsername : ''; ?>";

$(document).ready(function() {
    var ww = $(window).width();
    var w = $('.delete-dialog > div').width();
    $('.delete-dialog > div').css('left', (ww-w)/2);
});

const deleteDialog = {
    tweetId: null,

    open: (tweet) => {
        if(!auth) {
            window.location.href = 'logIn';
            return;
        }
        this.tweetId = tweet.id;
        const dialog = $('.delete-dialog');
        $('.dialog').hide();
        dialog.show();
        $('.delete-dialog .body').empty();
        tweetDOM.appendTo('.delete-dialog .body', tweet);
    },

    close: () => {
        $('.delete-dialog').hide();
    },

    deleteTweet: () => {
        this.close();
        const target = $('.tweet-' + this.tweetId);
        target.animate({ 'padding-top': '0px', 'height': '0px', 'opacity': '0' }, 'fast', 'linear', () => {
            target.hide();
        });
        $.ajax({
            url: '/tweets/'+this.tweetId,
            type: 'DELETE',
            data: {"_token": "{{ csrf_token() }}"},
            success: () => {
                target.remove();
                if (profileId && profileId === auth.id) {
                    const tweets = parseInt($('.profile-tweets').html(), 10);
                    if (tweets > 0) {
                        $('.profile-tweets').html(tweets - 1);
                    }
                }
            },
            error: () => {
                target.show();
                target.css({ 'padding-top': '7.5px', 'height': '100%', 'opacity': '1' });
            },
        });
    }
};

$(document).ajaxError(function(e){
    console.log(e);
});
</script>
