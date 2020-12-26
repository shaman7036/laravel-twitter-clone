<style>
.profile .bg {
    position: relative;
    margin-top: 46px;
    padding-bottom: 25%;
    overflow: hidden;
    z-index: 10;
    width: 100%;
}
.profile .bg > img {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    border: 0px solid;
    z-index: 0;
}
.profile .nav {
    position: relative;
    width: 100%;
    height: 60px;
    top: 0px;
    background: #fff;
    box-shadow: 1px 2px 1px rgba(0, 0, 0, 0.1);
    z-index: 200;
}
.profile .nav > div {
    position: relative;
    margin: 0 auto;
}
.profile .nav .avatar {
    position: absolute;
    width: 210px;
    height: 210px;
    left: 0px;
    top: -105px;
    border: 5px solid #fff;
    border-radius: 100%;
    background: #eee;
    overflow: hidden;
    z-index: 1001;
}
.profile .nav .avatar img {
    width: 100%;
    height: 100%;
}
.profile .nav .avatarCard {
    position: absolute;
    width: 250px;
    height: 50px;
    display: none;
}
.profile .ac-avatar {
    position: absolute;
    top: 10px;
    width: 40px;
    height: 40px;
    border-radius: 100%;
    overflow: hidden;
}
.profile .ac-avatar img {
    width: 100%;
}
.profile .ac-fullname, .profile .ac-username {
    position: relative;
    width: 100%;
    height: 30px;
    border: 0px solid;
    padding-left: 50px;
}
.profile .ac-fullname {
    padding-top: 7px;
    font-size: 18px;
    font-weight: bold;
}
.profile .ac-username {
    bottom: 2px;
    font-size: 16px;
    color: #0ae;
}
.profile .nav ul {
    position: relative;
    display: inline-block;
    left: 313px;
    top: 0px;
    height: 60px;
    border: 0px solid;
}
.profile .nav ul li, .profile .nav ul li a {
    float: left;
    width: auto;
    height: 60px;
}
.profile .nav ul li a {
    padding: 0 15px;
    padding-top: 11px;
}
.profile .nav ul li a:hover, .profile .nav ul li.active a {
    color: #0ae;
    border-bottom: 2px solid;
}
.profile .nav ul li span {
    display: block;
    text-align: center;
    width: 100%;
    font-weight: bold;
    line-height: 18px;
}
.profile .nav ul li span:first-child {
    font-size: 12px;
    font-weight: 700 !important;
    margin-bottom: 0.5px;
}
.profile .nav ul li span:last-child {
    font-size: 18px;
    font-weight: 900 !important;
}
.profile .nav button {
    position: absolute;
    right: 0px;
    top: 0px;
    min-width: 105px;
    height: 36px;
    line-height: 18px;
    border-radius: 100px;
    margin-top: 12px;
    font-weight: bold;
    font-size: 15px;
    background: #fff;
    color: #0ae;
    border: 1px solid #0ae;
    padding: 0 15px;
    padding-top: 0px;
}
.profile .nav button.edit {
    padding-top: 0px;
}
.profile .nav button.follow:after {
    content: 'Follow';
}
.profile .nav button.active {
    border: 1px solid #0ae;
    background: #0ae;
    color: #fff;
}
.profile .nav button.active:after {
    content: 'Following';
}
.profile .nav button.active:hover {
    border: 1px solid #f22;
    background: #f22;
}
.profile .nav button.active:hover:after {
    content: 'Unfollow';
}
.profile .main {
    position: relative;
    display: inline-block;
    width: 100%;
    margin-top: 13px;
    z-index: 100;
}
.profile .main > div {
    position: relative;
    display: block;
    width: 1190px;
    margin: 0 auto;
}
.profile .main > div > div {
    float: left;
    border: 0px solid;
}
.profile .main > div .left {
    display: inline-block;
    background: rgba(0, 0, 0, 0);
    margin-top: 15px;
    margin-bottom: 30px;
    padding-top: 7.5px;
    padding-bottom: 30px;
    width: 25%;
    height: auto;
    overflow: hidden;
}
.profile .main > div .center {
    display: inline-block;
    width: 50%;
    padding-left: 30px;
    padding-right: 30px;
    padding-bottom: 45px;
    margin-bottom: 120px;
}
.profile .main > div .center .users {
    position: relative;
    width: 150%;
    top: 0px;
}
.profile .main > div .center .users li {
    margin-left: 6px;
    margin-right: 6px;
    margin-bottom: 12px;
}
.profile .main > div .right {
    display: inline-block;
    width: 25%;
    padding-left: 7px;
}
.profile .main .left .content {
    display: block;
    text-align: left;
    padding-left: 15px;
    width: 100% !important;
}
.profile .main .left .content h1 {
    margin-top: 20px;
    margin-bottom: 5px;
}
.profile .main .left .content h1 > span {
    display: block;
    margin-bottom: 5px;
}
.profile .main .left .content .fullname {
    font-size: 20px;
    font-weight: bold;
}
.profile .main .left .content .username {
    font-size: 16px;
    color: #888;
    margin-top: 3px;
}
.profile .main .left .content .bio {
    padding-top: 10px;
    padding-bottom: 10px;
}
.profile .main .left .content .bio a {
    color: #0ae;
}
.profile .main .left .content > div > i {
    font-size: 18px;
    margin-right: 5px;
    color: #888;
    width: 20px;
}
.profile .main .left .content .location,
.profile .main .left .content .url > a,
.profile .main .left .content .date {
    color: #888;
    padding-top: 4px;
    padding-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
}
.profile .main .left .content .url {
    white-space: nowrap;
}
.profile .main .left .content .url > a {
    color: #0ae;
}
</style>
