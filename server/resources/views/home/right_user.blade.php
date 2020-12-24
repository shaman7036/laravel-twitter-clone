@include('home/rightUser-style')
<?php
    if(isset($user->avatar)) {
        $avatar = '/storage/media/'.$user->id.'/avatar/avatar.'.$user->avatar;
    }

    if($user->followed === 1) {
        $followed = 'active';
    } else {
        $followed = '';
    }
?>
<div class="{{'right-user right-user-'.$user->id}}">
    <a class='avatar' href="{{'/profile/tweets/'.$user->username}}">
        <img src={{$avatar}} onerror="this.style.display='none'" />
        <i class='fa fa-user'></i>
    </a>
    <div class='top'>
        <span class='name'>{{$user->name}}</span>
        <span class='username'>{{'@'.$user->username}}</span>
    </div>
    <div class='bottom'>
        <button class="{{'btn btn-default '.$followed}}" onclick="followUser({{$user->id}})"></button>
    </div>
</div>
