<style>
.profile .right {
    padding-left: 15px;
    padding-right: 0px;
}

.users {
    position: relative;
    display: block;
    z-index: 1;
}

.user {
    position: relative;
    display: inline-block;
    width: 31% !important;
    height: 300px;
    border: 1px solid #ccc;
    margin: 0 7.5px;
    margin-bottom: 15px;
    background: #fff;
    overflow: hidden;
    text-align: left;
    float: left;
}

.user .avatar {
    display: inline-block;
    position: absolute;
    width: 70px;
    height: 70px;
    border: 3px solid #ccc;
    border-radius: 100%;
    top: 22%;
    left: 15px;
    overflow: hidden;
    z-index: 10;
    background: #fff;
}

.user .avatar img {
    position: relative;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
}

.user .bg {
    display: inline-block;
    position: relative;
    left: 0px;
    top: 0px;
    width: 100%;
    margin-top: 0px !important;
    overflow: hidden;
    padding-top: 15%;
    z-index: 0;
    border: 0px solid;
    border-bottom: 0px solid;
    background: #0ae;
}

.user .bg img {
    position: absolute;
    left: 0px;
    top: 0px;
    width: auto;
    height: 100%;
}

.user .fullname {
    position: relative;
    display: block;
    font-size: 18px;
    left: 15px;
    top: 45px;
}

.user .username {
    position: relative;
    display: block;
    font-size: 14px;
    left: 15px;
    top: 45px;
    color: #888;
}

.user .followsYou {
    position: relative;
    display: inline-block;
    background: #eee;
    color: #555;
    top: 0px;
    padding: 0px 5px;
    font-size: 12px;
    line-height: 18px;
    border-radius: 4px;
    margin-left: 7.5px;
}

.user .info {
    position: relative;
}

.user .user-follow-button {
    position: absolute;
    width: 85px;
    height: 28px;
    line-height: 11px;
    border-radius: 15px;
    right: 15px;
    top: 12.5px;
    font-size: 13px;
    font-weight: bold;
    background: #fff;
    color: rgb(29, 161, 242);
    border: 1px solid rgb(29, 161, 242);
}

.user .user-follow-button:after {
    content: 'Follow';
}

.user .user-follow-button.active {
    border: 1px solid rgb(29, 161, 242);
    background: rgb(29, 161, 242);
    color: #fff;
}

.user .user-follow-button.active:after {
    content: 'Following';
}

.user .user-follow-button.active:hover {
    border: 1px solid #f22;
    background: #f22;
}

.user .user-follow-button.active:hover:after {
    content: 'Unfollow';
}

.user .description {
    position: relative;
    width: 100%;
    height: 70px;
    top: 45px;
    padding: 0px 15px;
    overflow: hidden;
}
</style>
