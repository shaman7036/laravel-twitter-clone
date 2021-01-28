<div class="tweet-menu" id="tweet-menu-{{$tweet->id}}" style="display: none">
    <div><div></div></div>
    <ul>
        <!-- login -->
        @if (!$auth)
            <li class="menu-item menu-item-login">
                <a class="a" href="/login"><i class="fa fa-sign-in"></i> Log In</a>
            </li>
        @endif
        <!-- report tweet -->
        @if ($auth && $auth->id != $tweet->user_id)
            <li class="menu-item menu-item-report">
                <i class="fa fa-flag-o"></i> Report Tweet
            </li>
        @endif
        <!-- pin tweet -->
        @if ($auth && $auth->id == $tweet->user_id)
            <li class="menu-item menu-item-pin {{$tweet->is_pinned ? 'is-pinned' : ''}}" onclick="tweetEvents.pinTweet({{$tweet->id}})">
                <i class="fa fa-thumbtack"></i>
                <span class="a"></span>
            </li>
        @endif
        <!-- delete tweet -->
        @if ($auth && $auth->id == $tweet->user_id)
            <li class="menu-item menu-item-delete" onclick="deleteDialog.open({{$tweet}})">
                <i class="fa fa-trash-o"></i> Delete Tweet
            </li>
        @endif
    </ul>
</div>
