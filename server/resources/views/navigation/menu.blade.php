<?php
    $auth = Session::get('auth')
?>
@include('navigation/menu_style')
@if($auth)
<div class='menu'>
    <div><div></div></div>
    <ul>
        <li class='menuUser'>
            <a href={{'/profile/tweets/'.$auth->username}} style="width: 100%; height: 100%">
                @if($auth->fullname)<span>{{$auth->fullname}}</span>@endif
                <span>{{'@'.$auth->username}}</span>
            </a>
        </li>
        <li class='menuFollowing'>
            <a href={{'/profile/following/'.$auth->username}}>
                {{$auth->following ? $auth->following : 0}} Following
            </a>
        </li>
        <li class='menuFollowers'>
            <a href={{'/profile/followers/'.$auth->username}}>
                {{$auth->followers ? $auth->followers : 0}} Followers
            </a>
        </li>
        <li class='menuLikes'>
            <a href={{'/profile/likes/'.$auth->username}}>
                {{$auth->likes ? $auth->likes : 0}} Likes
            </a>
        </li>
        <li class='logout'><a href='/logout'>Log out</a></li>
    </ul>
</div>
@endif
