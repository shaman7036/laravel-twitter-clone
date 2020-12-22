<nav class='navigation'>
    <?php
        $avatar = '';
        $auth = null;
        if (Session::get('auth')) {
            $auth = Session::get('auth');
            if(isset($auth->avatar)) {
                $avatar = '/storage/media/'.$auth->id.'/avatar/thumbnail.'.$auth->avatar;
            }
        }
        $links = array('', '', '', '', '');
        $url = url()->current();
        if(strrpos($url, '/home')) $links[0] = 'active';
        else if(strrpos($url, '/moments')) $links[1] = 'active';
        else if(strrpos($url, '/notifications')) $links[2] = 'active';
        else if(strrpos($url, '/messages')) $links[3] = 'active';
        else if(strrpos($url, '/profile')) {
        if(isset($auth) && strrpos($url, '/'.$auth->username)) $links[4] = 'active';
        }
    ?>
    <ul>
        <!-- to home -->
        <li class='left {{$links[0]}}'>
        <a href='/home' ><i class='fa fa-home'></i><span>Home</span></a>
        </li>
        <!-- to moments -->
        <li class='left {{$links[1]}}'>
        <a href='/moments' ><i class='fa fa-bolt'></i><span>Moments</span></a>
        </li>
        <!-- to notifications -->
        <li class='left {{$links[2]}}'>
        <a href='/notifications' ><i class='fa fa-bell-o'></i><span>Notifications</span></a>
        </li>
        <!-- messeages -->
        <li class='left {{$links[3]}}'>
        <a href='/messages' ><i class='fa fa-envelope-o'></i><span>Messages</span></a>
        </li>
        <!-- center -->
        <li class='center'>
        <div class='twitter'><i class='fa fa-twitter'></i></div>
        <div class='center_loader spinner_wrapper'>
            <div class='spinner'></div>
        </div>
        </li>
        <!-- tweet button -->
        <li class='right li_post'><div onclick='tweetDialog.openTweetDialog()'>Tweet</div></li>
        <!-- avatar -->
        <li class='right li_user {{$links[4]}}'>
        <div class='avatar' onclick='showMenu()'>
            @if(!$avatar)
            <i class='fa fa-user'></i>
            @else
            <img src="{{$avatar}}" onerror="this.style.display='none'" />
            @endif
        </div>
        <a class='mobile' href="<?php echo (isset($auth)) ? '/profile/tweets/'.$auth->username : '/logIn'; ?>">
            <i class='fa fa-user-o mobile'></i>
        </a>
        @include('navigation/menu')
        </li>
        <li class='right li_search'>
        @include('navigation/search')
        </li>
    </ul>
    <div class='mobile createTweet' onclick='tweetDialog.openTweetDialog()'>
        <i class='fa fa-pencil'></i>
    </div>
    {{-- @include('dialogs/tweet_dialog')
    @include('dialogs/delete_dialog')
    @include('dialogs/reply_dialog')
    @include('dialogs/replies')
    @include('dialogs/dialog_mobile') --}}
</nav>

<script>
var auth = '';
<?php if(Session::get('auth')) echo 'auth = '.$auth; ?>;
spin_center(false);

var scrollTop = 0;
$(document).ready(function() {
    $(window).scroll(function() {
        if($(window).width() <= 960) { // mobile
            var t = $(window).scrollTop();
            if(t >= scrollTop) {
                $('.createTweet').fadeOut(200);
            } else {
                $('.createTweet').fadeIn(0);
            }
            scrollTop = t;
        }
    });
});

function spin_center(loading) {
    if(loading) {
        _('.twitter').style.display = 'none';
        _('.center_loader').style.display = 'block';
    } else {
        _('.twitter').style.display = 'block';
        _('.center_loader').style.display = 'none';
    }
}

function showMenu() {
    if(auth && auth.username) {
        $('.menu').toggle();
    } else {
        window.location.href = '/';
    }
}

function add_active(index) {
    var li = $('.navigation > ul > li').eq(index);
    li.addClass('active');
}
</script>

@include('navigation/navigation_style')
@include('navigation/navigation_mobile')
