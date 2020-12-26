<?php
    $auth = '';
    if (Session::get('auth')) $auth = Session::get('auth');

    $arr = array();
    foreach($tweets as $t) {
        array_push($arr, $t);
    }
?>
<div class='tweets'>
    <div class='header'>
        <ul class='tweets_ul'>
            <li class='li_tweets active' onclick='get_tweets()'>
                <router-link :to="'/profile?user='+this.username">Tweets</router-link>
            </li>
            <li class='li_replies' onclick='get_replies()'>
                <router-link :to="'/profile/replies?user='+this.username">Tweets & replies</router-link>
            </li>
            <li class='li_media' onclick='get_media()'>
                <router-link :to="'/profile/media?user='+this.username">Media</router-link>
            </li>
        </ul>
    </div>
    <div class='body'>
        <ul>
        @foreach($tweets as $t)
            <li>
            @include('tweets/tweet', ['tweet' => $t])
            </li>
        @endforeach
        </ul>
    </div>
    <!--div class='footer' onclick='show_more()'>
        <span>Show more...</span>
    </div-->
    <div class='footer' onclick='back_to_top()'>
        <span>Back to Top</span>
    </div>
</div>
<script>
tweets = <?php echo json_encode($arr); ?>;

function back_to_top() {
    $([document.documentElement, document.body]).animate({
        scrollTop: $(".profile .nav ").offset().top
    }, 500);
}
</script>

@include('tweets/tweets_style')
