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
            <div class="loader">...Loading</div>
            <span class="back-to-top">Back to Top</span>
        </div>
    </div>
    <ul class="user-dom-wrapper" style="display: none">
        <li class="user user-dom default row">
            <div class="col col-md-2 col-sm-3 col-xs-4">
                <!-- avatar -->
                <a class="avatar"><i class="fa fa-user"></i></a>
            </div>
            <div class="col col-md-10 col-sm-9 col-xs-8 left-col">
                <div class="row fullname">Full Name</div>
                <div class="row username">@username</div>
                <div class="row description">Description</div>
                <a class="btn btn-default follow-button"></a>
            </div>
        </li>
    </ul>
</div>

<script>
const usersDialog = {
    maxHeight: 0.9, // 1.0 = window height

    open(from, tweetId) {
        $('.dialog').not('.tweet-details-dialog').hide();
        const dialog = $('.users-dialog');
        dialog.show();
        this.setLoader(true);

        // set header title
        if (from === 'replies') $('.users-dialog .modal-header h3').html('Replied By');
        else if (from === 'retweets') $('.users-dialog .modal-header h3').html('Retweeted By');
        else $('.users-dialog .modal-header h3').html('Liked By');

        // set max height and top
        const dh = dialog.height();
        dialog.find('.wrapper').css('max-height', dh * this.maxHeight);
        dialog.find('.wrapper').css('top', dh * (1 - this.maxHeight) / 2);

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
            },
            complete: () => this.setLoader(false),
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
        clone.addClass('user-dom-' + data.user_id);
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
        // follow button
        if (auth.id !== data.user_id) {
            clone.find('.follow-button').on('click', () => followEvents.followUserInUsersDialog(data.user_id));
            if (data.is_followed) clone.find('.follow-button').addClass('active');
        } else {
            clone.find('.follow-button').remove();
        }
        clone.show();
    },

    setLoader(loading) {
        const footer = $('.users-dialog .modal-footer');
        if (loading) {
            footer.find('.loader').show();
            footer.find('.back-to-top').hide();
        } else {
            footer.find('.loader').hide();
            footer.find('.back-to-top').show();
            if ($('.users-dialog .users').html() === '') {
                footer.find('.back-to-top').html('No one yet');
            } else {
                footer.find('.back-to-top').html('Back to Top');
            }
        }
    },

    backToTop() {
        $('.users-dialog .wrapper').stop().animate({ scrollTop: 0 }, 150);
    },
};
</script>
