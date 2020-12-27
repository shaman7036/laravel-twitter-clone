@extends('layouts.app')
@section('content')
<?php
    $links = array('', '', '', '');
    $url = url()->current();
    if(strrpos($url, '/profile/tweets/')) $links[0] = 'active';
    else if(strrpos($url, '/profile/following/')) $links[1] = 'active';
    else if(strrpos($url, '/profile/followers/')) $links[2] = 'active';
    else if(strrpos($url, '/profile/likes/')) $links[3] = 'active';

    if(isset($profile->bg)) {
        $profile->bg = '/storage/media/'.$profile->id.'/bg/bg.'.$profile->bg;
    }

    $avatarThumb = '';
    if(isset($profile->avatar)) {
        $avatarThumb = '/storage/media/'.$profile->id.'/avatar/thumbnail.'.$profile->avatar;
        $profile->avatar = '/storage/media/'.$profile->id.'/avatar/avatar.'.$profile->avatar;
    }

    $auth = (object)['username' => ''];
    if (Session::get('auth')) {
        $auth = Session::get('auth');
    }

    $time = strtotime($profile->created_at);
    $date = 'Joined '.date('M', $time).' '.date('Y', $time);

    if(isset($profile->url)) {
        $url = $profile->url;
        $url = str_replace('http://', '', $url);
        $url = str_replace('https://', '', $url);
        $url = str_replace('www.', '', $url);
    }

    // add links in bio
    $bio = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a class="link" href="/hashtag/$1">#$1</a>', $profile->description);
    $bio = preg_replace('/(?<!\S)@([0-9a-zA-Z_-]+)/', '<a class="link" href="/profile/tweets/$1">@$1</a>', $bio);
    $bio = preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$3</a>', $bio);
?>
<div class="profile">
    <div class="bg">
        @if (isset($profile->bg))
            <img src={{$profile->bg}} onerror="this.style.display='none'" />
        @endif
    </div>
    <div class="nav">
        <div class="container">
        <a class="avatar" href={{'/profile/tweets/'.$profile->username}}>
            @if (isset($profile->avatar))
                <img src={{$profile->avatar}} onerror="this.style.display='none'" />
            @endif
        </a>
        <a class="avatarCard" href={{'/profile/tweets/'.$profile->username}}>
            <div class="ac-avatar">
                @if (isset($profile->avatar))
                    <img src={{$avatarThumb}} onerror="this.style.display='none'" />
                @endif
            </div>
            <div class="ac-fullname">{{$profile->fullname}}</div>
            <div class="ac-username">{{'@'.$profile->username}}</div>
        </a>
        <ul class="profile-ul">
            <li class={{$links[0]}}>
            <a href={{'/profile/tweets/'.$profile->username}}>
                <span>Tweets</span>
                <span class="profile-tweets">{{$profile->num_tweets ? $profile->num_tweets : 0}}</span>
            </a>
            </li>
            <li class={{$links[1]}}>
            <a href={{'/profile/following/'.$profile->username}}>
                <span>Following</span>
                <span class="profile-following">{{$profile->num_following ? $profile->num_following : 0}}</span>
            </a>
            </li>
            <li class={{$links[2]}}>
            <a href={{'/profile/followers/'.$profile->username}}>
                <span>Followers</span>
                <span class="profile-followers">{{$profile->num_followers ? $profile->num_followers : 0}}</span>
            </a>
            </li>
            <li class={{$links[3]}}>
            <a href={{'/profile/likes/'.$profile->username}} >
                <span>Likes</span>
                <span class="profile-likes">{{$profile->num_likes ? $profile->num_likes : 0}}</span>
            </a>
            </li>
        </ul>
        @if ($profile->username === $auth->username)
            <button class="btn btn-default edit">
                <a href="/profile/edit/{{$profile->username}}">Edit Profile</a>
            </button>
        @else
            <button
                class="btn btn-primary follow {{ $profile->is_followed ? 'active' : '' }}"
                onclick="followEvents.followProfile('{{$profile->id}}')">
            </button>
        @endif
        </div>
    </div>
    <div class="main container">
        <div>
            <!-- left -->
            <div class="left">
                <div class="content">
                    <h1>
                        <!-- fullname -->
                        <span class="fullname">{{$profile->fullname}}</span>
                        <!-- username -->
                        <span class="username">{{'@'.$profile->username}}</span>
                    </h1>
                    <!-- description -->
                    <p class="bio"><?php echo htmlspecialchars_decode($bio); ?></p>
                    <!-- location -->
                    <?php if(!empty($profile->location)) : ?>
                        <div class="location">
                        <i class="fa fa-map-marker"></i>
                        {{$profile->location}}
                        </div>
                    <?php endif; ?>
                    <!-- website -->
                    <?php if(!empty($profile->website)) : ?>
                        <div class="url">
                        <i class="fa fa-link"></i>
                        <a href="{{'https://'.$url}}">{{$url}}</a>
                        </div>
                    <?php endif; ?>
                    <!-- joined date -->
                    <div class="date">
                        <i class="fa fa-calendar"></i>
                        {{$date}}
                    </div>
                    <div class="mobile">
                        <a class="{{'mobile-tweets '.$links[0]}}" href={{'/profile/tweets/'.$profile->username}}>
                        <span>{{$profile->tweets}}</span> Tweets</a>
                        <a class="{{'mobile-likes '.$links[3]}}" href={{'/profile/likes/'.$profile->username}}>
                        <span>{{$profile->likes}}</span> Likes</a>
                        <a class="{{'mobile-following '.$links[1]}}" href={{'/profile/following/'.$profile->username}}>
                        <span>{{$profile->following}}</span> Following</a>
                        <a class="{{'mobile-followers '.$links[2]}}" href={{'/profile/followers/'.$profile->username}}>
                        <span>{{$profile->followers}}</span> Followers</a>
                    </div>
                </div>
            </div>
            <!-- center -->
            <div class="center">
                @if($links[0] || $links[3])
                    <div>
                        <!-- tweets -->
                        @include('tweets/tweets', ['tweets' => $tweets])
                        <!-- pagination -->
                        @include('layouts.pagination', ['pagination' => $pagination])
                    </div>
                @else
                    <!-- users -->
                    <ul class='users'>
                        @isset($users)
                        @foreach($users as $u)
                            @include('profile/user', [
                                'user' => $u, 'isAuth' => ($u->username === $auth->username),
                            ])
                        @endforeach
                        @endisset
                    </ul>
                @endif
            </div>
            <!-- right -->
            <div class="right"></div>
        </div>
    </div>
</div>

<script>
var profileUsername = "<?php echo $profile->username; ?>";

// add page parameter if url doesn't have
if (window.location.href.indexOf('?page=') === -1) {
    var url = window.location.href;
    window.history.pushState({} , url, url + '?page=1');
}

document.addEventListener('DOMContentLoaded', function() {
    var bgh = parseInt($('.profile .bg').css('height'));
    var scroll = 'up';
    $(window).scroll(function() {
        if($(window).width() > 1000) { // desktop
            var t = $(window).scrollTop();
            if(t >= bgh && scroll === 'up') {
                scroll = 'down';
                $('.profile .nav').css({'position': 'fixed', 'top': (45)});
                $('.main').css({'margin-top': 70});
                $('.profile .nav .avatar').fadeOut(100);
                $('.profile .nav .avatarCard').fadeIn(200);
            } else if(t < bgh && scroll === 'down' && t < 300) {
                scroll = 'up';
                $('.profile .nav').css({'position': 'relative', 'top': '0px'});
                $('.main').css({'margin-top': 13});
                $('.profile .nav .avatar').fadeIn(200);
                $('.profile .nav .avatarCard').fadeOut(100);
            }
        }
    });
});
</script>

@include('profile/profile_style')
@include('profile/profile_mobile')
@endsection
