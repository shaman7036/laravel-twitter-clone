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
    <div class='profile'>
    <div class='bg'>
        <img src={{$profile->bg}} onerror="this.style.display='none'" />
    </div>
    <div class='nav'>
        <div class='container'>
        <a class='avatar' href={{'/profile/tweets/'.$profile->username}}>
            <img src={{$profile->avatar}} onerror="this.style.display='none'" />
        </a>
        <a class='avatarCard' href={{'/profile/tweets/'.$profile->username}}>
            <div class='ac-avatar'>
            <img src={{$avatarThumb}} onerror="this.style.display='none'" />
            </div>
            <div class='ac-fullname'>{{$profile->fullname}}</div>
            <div class='ac-username'>{{'@'.$profile->username}}</div>
        </a>
        <ul class='profile_ul'>
            <li class={{$links[0]}}>
            <a href={{'/profile/tweets/'.$profile->username}}>
                <span>Tweets</span>
                <span class='profile-tweets'>{{$profile->tweets}}</span>
            </a>
            </li>
            <li class={{$links[1]}}>
            <a href={{'/profile/following/'.$profile->username}}>
                <span>Following</span>
                <span class='profile-following'>{{$profile->following}}</span>
            </a>
            </li>
            <li class={{$links[2]}}>
            <a href={{'/profile/followers/'.$profile->username}}>
                <span>Followers</span>
                <span class='profile-followers'>{{$profile->followers}}</span>
            </a>
            </li>
            <li class={{$links[3]}}>
            <a href={{'/profile/likes/'.$profile->username}} >
                <span>Likes</span>
                <span class='profile-likes'>{{$profile->likes}}</span>
            </a>
            </li>
        </ul>
        @if($profile->username === $auth->username)
            <button class='btn btn-default edit' onclick='editProfile("{{$profile->username}}")'>
            Edit Profile
            </button>
        @elseif($profile->followed === 1)
            <button class='btn btn-primary follow followed' onclick='followProfile("{{$profile->id}}")'></button>
        @elseif($profile->followed === 0)
            <button class='btn btn-primary follow' onclick='followProfile("{{$profile->id}}")'></button>
        @endif
        </div>
    </div>
    <div class='main container'>
    <div>
        <div class='left'>
        <div class='content'>
            <h1>
                <span class='fullname'>{{$profile->fullname}}</span>
                <span class='username'>{{'@'.$profile->username}}</span>
            </h1>
            <p class='bio'><?php echo htmlspecialchars_decode($bio); ?></p>
            <?php if(!empty($profile->location)) : ?>
                <div class='location'>
                <i class='fa fa-map-marker'></i>
                {{$profile->location}}
                </div>
            <?php endif; ?>
            <?php if(!empty($profile->url)) : ?>
                <div class='url'>
                <i class='fa fa-link'></i>
                <a href="{{'https://'.$url}}">{{$url}}</a>
                </div>
            <?php endif; ?>
            <div class='date'>
                <i class='fa fa-calendar'></i>
                {{$date}}
            </div>
            <div class='mobile'>
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
        <div class='center'>
            {{-- @if($links[0] || $links[3])
            <div>
                @include('tweets/tweets', ['tweets' => $tweets])
            </div>
            @else
            <ul class='users'>
                @isset($users)
                @foreach($users as $u)
                    @include('profile/user', ['user' => $u])
                @endforeach
                @endisset
            </ul>
            @endif --}}
        </div>
        <div class='right'>
        </div>
        </div>
    </div>
</div>

<script>
var authId = "<?php echo (Auth::check()) ? Auth::user()->id : ''; ?>";
var profileId = "<?php echo $profile->id; ?>";

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

function editProfile(username) {
    window.location.href = '/profile/edit/' + username;
}

function followProfile(id) {
}
</script>

@include('profile/profile_style')
@include('profile/profile_mobile')
@endsection
