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
        $.ajax({
            url: '/tweets/'+this.tweetId,
            type: 'DELETE',
            data: {"_token": "{{ csrf_token() }}"},
            success: function(res) {
                window.location.href = '/profile/tweets/'+authUsername;
            }
        });
    }
};

$(document).ajaxError(function(e){
    console.log(e);
});
</script>

@include('dialogs/delete_dialog_style')
