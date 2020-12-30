<div class="users-dialog dialog animated fadeIn" onclick="usersDialog.close(event)">
    <div class="modal-content wrapper animated fadeInUp">
        <!-- header -->
        <div class="modal-header">
            <h3>Users Dialog</h3>
            <i class="fa fa-times close-dialog" onclick="usersDialog.close(event)"></i>
        </div>
        <!-- body -->
        <div class="modal-body">
            <ul class="users"></ul>
        </div>
        <!-- footer -->
        <div class="modal-footer" onclick="usersDialog.backToTop()">
            <span>Back to Top</span>
        </div>
    </div>
    <div class="user-dom-wrapper">
        <li class="user user-dom default row">
            <div class="col col-md-2">
                <!-- avatar -->
                <a class="avatar"><i class="fa fa-user"></i></a>
            </div>
            <div class="col col-md-10 left-col">
                <div class="row fullname">Full Name</div>
                <div class="row username">@username</div>
                <div class="row description">Description</div>
            </div>
            {{-- <a class="btn btn-default follow-button">Follow</a> --}}
        </li>
    </div>
</div>

<script>
const usersDialog = {
    open(from, tweetId) {
        $('.dialog').not('.tweet-details-dialog').hide();
        const dialog = $('.users-dialog');
        dialog.show();

        // set header title
        if (from === 'replies') $('.users-dialog .modal-header h3').html('Replied By');
        else if (from === 'retweets') $('.users-dialog .modal-header h3').html('Retweeted By');
        else $('.users-dialog .modal-header h3').html('Liked By');

        // set dialog max height
        const wh = $(window).height();
        dialog.find('.wrapper').css('max-height', wh * 0.9);

        // get users by url request
        dialog.find('.users').empty();
        $.ajax({
            type: 'GET',
            url: '/' + from + '?tweet_id=' + tweetId,
            data: {"_token": "{{ csrf_token() }}"},
            success: (res) => {
                if (res.users && res.users.length > 0) {
                    // append users to dialog
                    res.users.forEach(item => {
                        this.appendUser(item);
                    });
                }
                // make dialog center
                let h = dialog.find('.wrapper').height();
                dialog.find('.wrapper').css('top', (wh - h) / 2);
            },
            error: (err) => {
                console.log(err);
            },
        });
    },

    close(e) {
        e.stopPropagation();
        var list = e.target.classList.toString();
        if(list.indexOf('users-dialog') > -1 || list.indexOf('close-dialog') > -1) {
            $('.users-dialog').find('.users').empty();
            $('.users-dialog').hide();
        }
    },

    appendUser(data) {
        $('.users-dialog .user-dom-wrapper .user-dom.default:first').clone().appendTo('.users-dialog .users');
        const clone = $('.users-dialog .user-dom.default:first');
        clone.removeClass('default');
        clone.addClass('.user-dom-'+data.id);
        // avatar
        clone.find('.avatar').attr('href', '/profile/tweets/' + data.username + '?page=1');
        if (data.avatar) {
            const avatar = '/storage/media/' + data.user_id + '/avatar/thumbnail.' + data.avatar;
            clone.find('.avatar').html('<img class="avatarImg" src="'+ avatar +'" />');

        }
        // fullname
        clone.find('.fullname').html(data.fullname);
        // username
        clone.find('.username').html('@' + data.username);
        // description
        clone.find('.description').html(data.description);
        clone.show();
    },

    backToTop() {
        $('.users-dialog .wrapper').stop().animate({ scrollTop: 0 }, 150);
    },
};
</script>

@include('dialogs.users_dialog_style');
