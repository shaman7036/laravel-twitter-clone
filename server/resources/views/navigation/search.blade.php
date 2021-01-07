<div class="search">
    <!-- input -->
    <input class="form-control" onkeyup="search.onkeyup(event)" onblur="search.onblur()" />
    <i class="fa fa-search"></i>
    <!-- results -->
    <ul class="list-group results"></ul>
    <!-- hashtag dom -->
    <ul style="display: none">
        <li class="list-group-item hashtag hashtag-dom default">
            <a class="link">
                <span class="tag"></span><span class="badge"></span>
            </a>
        </li>
    </ul>
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
            $('.search .results').empty();
            return;
        }
        $.ajax({
            type: 'GET',
            url: '/search?q=' + e.target.value,
            data: {"_token": "{{ csrf_token() }}"},
            success: res => {
                $('.search .results').empty();
                if (res.hashtags && this.isFocused) {
                    Object.keys(res.hashtags).forEach(key => {
                        search.appendHashtag(key, res.hashtags[key]);
                    });
                }
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
            $('.search .results').empty();
        }, 10);
    },

    appendHashtag(key, value) {
        // clone and append
        $('.search .hashtag-dom.default:first').clone().appendTo('.search .results');
        const clone = $('.search .results .hashtag-dom.default:first');
        clone.removeClass('default');
        // link
        clone.find('.link').attr('href', '/home/hashtag/' + key.replace('#', '') + '?page=1');
        // hashtag
        clone.find('.tag').html(key);
        // number
        clone.find('.badge').html(value);
        clone.show();
    },

    appendUser(data) {
        // clone and append
        $('.search .user-dom.default:first').clone().appendTo('.search .results');
        const clone = $('.search .results .user-dom.default:first');
        clone.removeClass('default');
        clone.addClass('user-dom-' + data.user_id);
        // link
        clone.find('.link').attr('href', '/profile/tweets/' + data.username + '?page=1');
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
