<?php
    $color_retweeted = 'rgb(23, 191, 99)';
    $color_liked = 'rgb(224, 36, 94)';
?>
<style>
.tweet {
    padding-left: 70px;
    padding-top: 7.5px;
    border-bottom: 1px solid #ccc;
    font-size: 14px;
    overflow:;
    text-align: left;
    background: #fff;
}
.tweet:hover {
    background: #fdfdfd;
}
.tweet > div:not('avatar') {
    position: relative;
    display: block;
    width: 100%;
    border: 0px solid;
}
.tweet > .avatar {
    position: absolute;
    width: 48px;
    height: 48px;
    left: 10px;
    border: 1px solid #eee;
    border-radius: 100%;
    overflow: hidden;
    text-align: center;
    background: #eee;
    padding-top: 5px;
    margin-top: 5px;
}
.tweet .avatar i {
    position: relative;
    left: 2px;
    top: 3px;
    font-size: 50px;
    color: #888;
}
.tweet .avatar img {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
}
.tweet .info {
    position: relative;
    font-size: 15px;
}
.tweet .info .name {
    font-weight: bold;
}
.tweet .info .date {
    color: #888;
    font-size: 13px;
    margin-left: 0px;
}
.tweet .info .toggle {
    position: relative;
    float: right;
    padding: 15px;
    top: -15px;
    font-size: 18px;
    color: #888;
}
.tweet .content {
    padding-right: 16px;
    margin-top: 0px;
    margin-bottom: 10px;
}
.tweet .content a {
    color: #0ae;
}
.tweet .icons {
    display: inline-block;
    padding-top: 10px;
    color: #888;
    border: 0px solid;
}
.tweet .icons > div {
    float: left;
    width: 75px;
    font-size: 15px;
}

/* retweet icon */
.tweet .icons > .retweet-icon:hover,
.tweet .icons > .retweet-icon.active {
    cursor: pointer;
    color: <?php echo $color_retweeted; ?>;
}

/* like icon */
.tweet .icons > .like-icon:hover,
.tweet .icons > .like-icon.active {
    cursor: pointer;
    color: <?php echo $color_liked; ?>;
}
.tweet .icons i {
    margin-right: 7.5px;
}

.tweet .retweeted {
    color: #888;
    font-size: 14px;
    display: block;
    padding-right: 7.5px;
}
.tweet .replyingTo {
    color: #0ae;
    margin-bottom: 4px;
}
</style>
