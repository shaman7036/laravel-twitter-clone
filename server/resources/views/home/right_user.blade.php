<?php
    $avatar = $user->avatar ? '/storage/media/'.$user->id.'/avatar/avatar.'.$user->avatar : '';
?>
<div class="right-user" id="{{'right-user-'.$user->id}}">
    <!-- avatar -->
    <a class='avatar' href="{{'/profile/tweets/'.$user->username}}">
        @if ($avatar)
            <img src="{{$avatar}}" />
        @else
            <i class='fa fa-user'></i>
        @endif
    </a>
    <div class='top'>
        <!-- fullname -->
        <span class='fullname'>{{$user->fullname}}</span>
        <!-- username -->
        <span class='username'>{{'@'.$user->username}}</span>
    </div>
    <!-- follow button -->
    <div class='bottom'>
        @if (!$isAuth)
            <button
                class="btn btn-default follow-button {{ $user->is_followed ? 'active' : ''}}"
                onclick="followEvents.followUserInHome({{$user->id}})">
            </button>
        @endif
    </div>
</div>

@include('home/right_user_style')
