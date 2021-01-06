<div class="search">
    <!-- input -->
    <input class="form-control" onkeyup="search.onkeyup(event)" onblur="search.onblur()" />
    <i class="fa fa-search"></i>
    <!-- user list -->
    <ul class="list-group users"></ul>
    <!-- user dom -->
    <ul style="display: none">
        <li class="list-group-item user user-dom default">
            <a class="link">
                <!-- avatar -->
                <div class="avatar"><i class="fa fa-user"></i></div>
                <!-- fullname -->
                <div class="fullname"></div>
                <!-- username -->
                <div class="username"></div>
            </a>
        </li>
    </ul>
</div>

<script>
const search = {
    isFocused: false,

    onkeyup(e) {
        this.isFocused = true;
        if (e.target.value.length < 2) {
            $('.search .users').empty();
            return;
        }
        $.ajax({
            type: 'GET',
            url: '/search?q=' + e.target.value,
            data: {"_token": "{{ csrf_token() }}"},
            success: res => {
                $('.search .users').empty();
                if (res.users.length > 0 && this.isFocused) {
                    res.users.forEach(item => {
                        search.appendUser(item);
                    });
                }
            },
        });
    },

    onblur() {
        this.isFocused = false;
        setTimeout(() => {
            $('.search .users').empty();
        }, 10);
    },

    appendUser(data) {
        // clone and append
        $('.search .user-dom.default:first').clone().appendTo('.search ul.users');
        const clone = $('.search .users .user-dom.default:first');
        clone.removeClass('default');
        clone.addClass('user-dom-' + data.user_id);
        // link
        clone.find('.link').attr('href', '/profile/tweets/' + data.username);
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
        clone.show();
    },
};
</script>

@include('navigation.search_style')
