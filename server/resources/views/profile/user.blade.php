<?php
    $followsYou = '';
    $bg = '/storage/media/'.$user->id.'/bg/thumbnail.'.$user->bg;
    $avatar = '/storage/media/'.$user->id.'/avatar/thumbnail.'.$user->avatar;
?>
<li class='user' id={{'user-'.$user->id}}>
    <div class='wrapper'>
        <!-- bg -->
        <div class='bg' onclick='click_user("{{$user->username}}")'>
            <img src={{$bg}} onerror="this.style.display='none'" />
        </div>
        <!-- avatar -->
        <div class='avatar' onclick='click_user("{{$user->username}}")'>
            <img src={{$avatar}} onerror="this.style.display='none'" />
        </div>
        <div class='info'>
        <h3>
            <!-- fullname -->
            <span class='fullname'>{{$user->fullname}}</span>
            <!-- username -->
            <span class='username' onclick='click_user({{$user->id}})'>{{'@'.$user->username}}{{$followsYou}}</span>
        </h3>
        <!-- description -->
        <p class='description'>{{$user->description}}</p>
        <!-- follow button -->
        @if (!$isAuth)
            @if ($user->is_followed === 0)
                <button class='btn btn-default followButton' onclick='profile.follow("{{$user->id}}")'></button>
            @else
                <button class='btn btn-default followButton followed' onclick='profile.follow("{{$user->id}}")'></button>
            @endif
        @endif
        </div>
    </div>
</li>
@include('profile/user-style')

<script>
function click_user(username) {
    window.location.href = '/profile/tweets/'+username;
}
</script>
