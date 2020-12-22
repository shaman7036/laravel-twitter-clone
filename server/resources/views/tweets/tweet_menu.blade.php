<?php
    $delete = true;
?>
<div class='tweet-menu' id={{$id}}>
    <div><div></div></div>
    <ul>
        <li class='menu-item'>Pin to your profile page</li>
        <li class='menu-item'>Report Tweet</li>
        @if($delete)
            <li class='menu-item' onclick='open_delete_dialog("{{$tweetId}}")'>Delete Tweet</li>
        @endif
    </ul>
</div>

<script>
var id = "<?php echo $id ?>";
_id(id).style.display = 'none';
</script>

@include('tweets/tweet_menu_style')
