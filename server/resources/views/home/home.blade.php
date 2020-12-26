@extends('layouts.app')
@section('content')
<?php
    $avatar = $auth && $auth->avatar ? '/storage/media/'.$auth->id.'/avatar/thumbnail.'.$auth->avatar : '';
    $bg = $auth && $auth->bg ? '/storage/media/'.$auth->id.'/bg/thumbnail.'.$auth->bg : '';
?>
<div class='home container'>
    <!-- left -->
    <div class='left'>
        @if (isset($auth))
            <!-- auth user -->
            <div class='auth-user'>
                <!-- avatar -->
                <a class='avatar' href={{ '/profile/tweets/'.$auth->username }}>
                    <img src="{{ $avatar }}" onerror="this.style.display='none'">
                </a>
                <!-- bg -->
                <a class='bg' href={{ '/profile/tweets/'.$auth->username }}>
                    <img src="{{ $bg }}" onerror="this.style.display='none'">
                </a>
                <div class='content'>
                    <h2>
                        <!-- fullname -->
                        <span>{{ $auth->fullname }}</span>
                        <!-- username -->
                        <span>{{ '@' . $auth->username }}</span>
                    </h2>
                    <a class='logout btn btn-default mobile' href='/logout'>Log Out</a>
                    <ul>
                        <!-- number of tweets -->
                        <li>
                            <a href="{{ '/profile/tweets/'.$auth->username }}">
                                <span>Tweets</span>
                                <span>{{ $auth->num_tweets }}</span>
                            </a>
                        </li>
                        <!-- number of following -->
                        <li>
                            <a href="{{ '/profile/following/'.$auth->username }}">
                                <span>Following</span>
                                <span class='num-following'>{{ $auth->num_following }}</span>
                            </a>
                        </li>
                        <!-- number of followers -->
                        <li>
                            <a href="{{ '/profile/followers/'.$auth->username }}">
                                <span>Followers</span>
                                <span class="num-followers">{{ $auth->num_followers }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <!-- link to login -->
            <div class='left-login'>
                <a href='/login'>
                <span>Have an account?</span><br>
                <span>Log In</span>
                </a>
            </div>
        @endif
    </div>

    <!-- center -->
    <div class='center'>
        @include('home/timeline', ['tweets' => $tweets])
    </div>

    <!-- right -->
    <div class='right'>
        <h3>Who to follow</h3>
        @if (isset($users))
            <ul>
                @foreach($users as $u)
                    @include('home.right_user', ['user' => $u, 'isAuth' => ($auth && $u->username === $auth->username)])
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection

<script>
// add page parameter if url doesn't have
if (window.location.href.indexOf('?page=') === -1) {
    window.history.pushState({} , 'home', '/home?page=1');
}

function followUser(userId) {
    if (!auth) {
        window.location.href = '/login';
        return;
    }
    const button = $('#right-user-' + userId + ' .follow-button');
    if (!button.hasClass('active')) {
        // follow
        button.addClass('active');
    } else {
        // unfollow
        button.removeClass('active');
    }
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
        }
    });
}
</script>

@include('home.home_style')
@include('home.home_mobile')
