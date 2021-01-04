<style>
@media screen and (max-width: 960px) {

    .home.container .left .bg {
        padding-top: 33%;
        height: auto;
    }

    .home.container .left .bg img {
        position: absolute;
        left: -16%;
        width: auto;
        height: 100%;
    }

    .home.container .left .avatar {
        top: 0px;
        margin-top: 20%;
    }

    .home.container {
        width: 100%;
        margin-top: 60px;
        margin-bottom: 15px;
    }

    .home.container .left {
        position: relative;
        display: inline-block;
        float: none;
        width: 100%;
        height: auto;
    }

    .home .logout {
        position: absolute;
        border: 1px solid #fff;
        border-radius: 30px;
        line-height: 15px;
        width: 80px;
        height: 30px;
        right: 7.5px;
        bottom: 125px;
        color: #fff;
        background: rgba(0, 0, 0, 0);
    }

    .home.container .left .auth-user {
        position: relative;
        height: auto;
    }
    .home.container .center {
        position: relative;
        float: none;
        width: 100%;
        height: auto;
        padding: 0px;
    }
    .home.container .center .tweet {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .home .timeline .tweet .avatar {
        margin-left: 0px;
    }
}

@media screen and (max-width: 420px) {
    .home.container .center .tweet .icons, .reply .icons {
        width: 100%;
    }

    .home.container .center .tweet .icons > div, .reply .icons > div {
        width: 25%;
    }

    .reply .icons > div:last-child {
        padding-top: 5px;
    }

    .home.container .center .tweet .avatar {
        left: 0px;
    }

    .home.container .right {
        position: relative;
        float: none;
        width: 100%;
    }

    .home.container .left {
        margin-bottom: 15px;
    }

    .home.container .center {
        margin-bottom: -15px;
    }

    .home .timeline .tweet .avatar {
        margin-left: 7.5px;
    }
}
</style>
