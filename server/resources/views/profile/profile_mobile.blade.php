<style>
@media screen and (min-width: 960px) {
    .profile .mobile-profile-nav {
        display: none;
    }
}

@media screen and (max-width: 960px) {
    .profile .nav .profile-ul {
        display: none;
    }

    .profile .bg {
        position: relative;
        padding-bottom: 30%;
        overflow: hidden;
    }

    .profile .bg img {
        left: -15%;
        width: auto;
        height: 100%;
    }

    .profile .nav, .profile .nav .container {
        width: 100%;
        background: rgba(0, 0, 0, 0);
        box-shadow: 0px 0px 0px;
        z-index: 10;
    }

    .profile .nav .container > .avatar {
        position: absolute;
        left: 7.5px;
        top: -50px;
        width: 100px;
        height: 100px;
        z-index: 100;
    }

    .profile .nav .container button {
        right: 15px;
    }

    .profile .container {
        padding: 0px;
        margin: 0px;
        z-index: 0;
    }

    .profile .main > div {
        position: relative;
        width: 100%;
    }

    .profile .main > div > .left {
        position: relative;
        width: 100%;
        background: #fff;
        padding: 0px;
        margin: 0px;
        margin-top: -60px;
        padding-top: 45px;
        padding-bottom: 7.5px;
        z-index: 0;
    }

    .profile .main > div > .left .mobile-profile-nav {
        width: 100%;
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }

    .profile .main > div > .left .mobile-profile-nav > a {
        display: inline-block;
        width: 48%;
        padding: 2px 0px;
        padding-bottom:;
        color: #888;
        font-size: 14px;
    }

    .profile .main > div > .left .mobile-profile-nav > a > span {
        font-weight: bold;
        color: #262626;
    }

    .profile .main > div > .left .mobile-profile-nav > a.active,
    .profile .main > div > .left .mobile-profile-nav > a.active > span {
        color: #0ae;
    }

    .profile .main .left .content h1 {
        margin-top: 10px;
    }

    .profile .main > div > .center {
        padding: 0px;
        left: 0px;
        width: 100%;
        margin-bottom: -15px;
    }

    .profile .main > div > .center .header {
        display: none;
    }

    .profile .main > div > .center .tweets {
        width: 100%;
        top: -7.5px;
        border-top: 1px solid #ccc;
    }

    .profile .main > div > .center .tweets .tweet {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .profile .center .users {
        display: inline-block;
        width: 100% !important;
        padding: 7.5px;
    }

    .profile .center .users .user {
        width: 50% !important;
        background: rgba(0, 0, 0, 0);
        border: 0px solid;
        margin: 0px !important;
        padding: 7.5px;
    }

    .profile .center .users .user .wrapper {
        background: #fff;
        border: 0px solid;
        height: 100%;
        overflow: hidden;
    }

    .profile .center .users .user .bg {
        padding-top:;
    }

    .profile .center .users .user .bg img {
        width: auto;
        height: 100%;
    }

    .profile .center .users .user .avatar {
        top: 20%;
        width: 30%;
        height: auto;
    }

    .profile .center .users .user .info {
        top: -20px;
    }

    .profile .center .users .user .followButton {
        top: 7.5px;
        right: 7.5px;
    }

    .profile .center .users .user .info .fullname {
        font-size: 16px;
    }

    .profile .users .user .description {
        height: 95px;
    }

    @media screen and (max-width: 420px) {
        .profile .tweets .tweet .icons, .reply .icons {
        width: 100%;
    }

    .profile .tweets .tweet .icons > div, .reply .icons > div {
        width: 25%;
    }

    .replies .reply .icons > div:last-child {
        padding-top: 5px;
    }

    .profile .nav button {
        height: 30px;
    }
}
</style>
