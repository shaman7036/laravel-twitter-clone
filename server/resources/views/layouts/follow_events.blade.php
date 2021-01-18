<script>
const followEvents = {
    followProfile: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('.profile .follow');
        if (button.hasClass('requesting')) return;
        button.addClass('requesting');
        checkActivity(button);
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                numFollowers = $('.profile-followers').html();
                if (res.isFollowed) {
                    // followed
                    button.addClass('active');
                    numFollowers++;
                } else {
                    // unfollowed
                    button.removeClass('');
                    if (numFollowers > 0) numFollowers--;
                }
                $('.profile-followers').html(numFollowers);
            },
            complete: () => button.removeClass('requesting'),
        });
    },

    followUserInProfile: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('#user-' + userId + ' .user-follow-button');
        if (button.hasClass('requesting')) return;
        button.addClass('requesting');
        checkActivity(button);
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                if (res.isFollowed) {
                    // followed
                    button.addClass('active');
                    if (profileId && profileId === auth.id) {
                        const following = parseInt($('.profile-following').html(), 10);
                        $('.profile-following').html(following + 1);
                    }
                } else {
                    // unfollowed
                    button.removeClass('active');
                    if (profileId && profileId === auth.id) {
                        const following = parseInt($('.profile-following').html(), 10);
                        if (following > 0) {
                            $('.profile-following').html(following - 1);
                        }
                    }
                }
            },
            complete: () => button.removeClass('requesting'),
        });
    },

    followUserInHome: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('#right-user-' + userId + ' .follow-button');
        if (button.hasClass('requesting')) return;
        button.addClass('requesting');
        checkActivity(button);
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                let numFollowing = $('.home .num-following').html();
                if (res.isFollowed) {
                    // followed
                    button.addClass('active');
                    numFollowing++;
                } else {
                    // unfollowed
                    button.removeClass('active');
                    if(numFollowing > 0) {
                        numFollowing--;
                    }
                }
                $('.home .num-following').html(numFollowing);
            },
            complete: () => button.removeClass('requesting'),
        });
    },

    followUserInUsersDialog: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('.users-dialog .user-dom-' + userId + ' .follow-button:first');
        if (button.hasClass('requesting')) return;
        button.addClass('requesting');
        checkActivity(button);
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                if (res.isFollowed) {
                    // followed
                    button.addClass('active');
                } else {
                    // unfollowed
                    button.removeClass('active');
                }
            },
            complete: () => button.removeClass('requesting'),
        });
    },
};

function checkActivity(button) {
    if (!button.hasClass('active')) {
        button.addClass('active');
    } else {
        button.removeClass('active');
    }
}
</script>
