@extends('layouts.app')
@section('content')
<?php
    $auth = Session::get('auth') ? Session::get('auth') : null;
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
                                <span>{{ $auth['tweets'] }}</span>
                            </a>
                        </li>
                        <!-- number of following -->
                        <li>
                            <a href="{{ '/profile/following/'.$auth->username }}">
                                <span>Following</span>
                                <span class='following'>{{ $auth['following'] }}</span>
                            </a>
                        </li>
                        <!-- number of followers -->
                        <li>
                            <a href="{{ '/profile/followers/'.$auth->username }}">
                                <span>Followers</span>
                                <span>{{ $auth['followers'] }}</span>
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
                @foreach($users as $user)
                    @include('home.right_user', ['user' => $user])
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection

<script>
function followUser(userId) {
    if (!auth) {
        window.location.href = '/login';
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/follows',
        data: {"_token": "{{ csrf_token() }}", followed_id: userId},
        success: (res) => {
            if (res.isFollowed) {
                $('#right-user-' + userId + ' .follow-button').addClass('active');
            } else {
                $('#right-user-' + userId + ' .follow-button').removeClass('active');
            }
        }
    });
}
</script>

@include('home.home_style')
@include('home.home_mobile')
