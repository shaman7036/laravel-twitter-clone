<style>
.right-user {
    position: relative;
    border-bottom: 1px solid #ccc;
    padding: 7.5px 0px;
    margin-bottom: 6px;
    height: 70px;
}

.right-user > div {
    position: relative;
    width: 100%;
    height: 35px;
}

.right-user .avatar {
    position: absolute;
    left: 0px;
    top: 10.5px;
    width: 48px;
    height: 48px;
    border-radius: 100%;
    overflow: hidden;
    background: #eee;
    text-align: center;
    z-index: 1;
}

.right-user .avatar img {
    position: relative;
    width: 100%;
    height: 100%;
}

.right-user .avatar i {
    position: relative;
    font-size: 46px;
    left: 0px;
    top: 12px;
    color: #888;
}

.right-user .top {
    padding-left: 60px;
    white-space: nowrap;
    overflow: hidden;
}

.right-user .top > span.fullname {
    font-weight: bold;
}

.right-user .top > span.username {
    color: #888;
}

.right-user .bottom {
    padding-left: 60px;
}

.right-user .bottom button {
    position: relative;
    border: 1px solid #0ae;
    border-radius: 15px;
    top: -9px;
    width: 80px;
    height: 25px;
    line-height: 11px;
    font-size: 12px;
    font-weight: bold;
    background: #fff;
    color: #0ae;
}

.right-user .bottom button:after {
    content: 'Follow';
}

.right-user .bottom button.active {
    background: #0ae;
    color: #fff;
    border: 0px solid;
}

.right-user .bottom button.active:after {
    content: 'Following';
}

.right-user .bottom button.active:hover {
    background: #f00;
    color: #fff;
}

.right-user .bottom button.active:hover::after {
    content: 'Unfollow';
}
</style>
