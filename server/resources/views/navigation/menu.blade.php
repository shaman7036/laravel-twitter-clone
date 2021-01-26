@if($auth)
<div class='menu'>
    <div><div></div></div>
    <ul>
        <!-- fullname and username -->
        <li class='menu-user'>
            <a href={{'/profile/tweets/'.$auth->username}} style="display: block; width: 100%; height: 100%">
                @if($auth->fullname)<span>{{$auth->fullname}}</span>@endif
                <span>{{'@'.$auth->username}}</span>
            </a>
        </li>
        <!-- number of following -->
        <li class='menu-following'>
            <a href={{'/profile/following/'.$auth->username}}>
                {{$auth->num_following ? $auth->num_following : 0}} Following
            </a>
        </li>
        <!-- number of followers -->
        <li class='menu-followers'>
            <a href={{'/profile/followers/'.$auth->username}}>
                {{$auth->num_followers ? $auth->num_followers : 0}} Followers
            </a>
        </li>
        <!-- number of likes -->
        <li class='menu-likes'>
            <a href={{'/profile/likes/'.$auth->username}}>
                {{$auth->num_likes ? $auth->num_likes : 0}} Likes
            </a>
        </li>
        <!-- log out -->
        <li class='logout'><a href='/logout'>Log out</a></li>
    </ul>
</div>
@endif
