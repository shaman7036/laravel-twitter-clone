<style>
@media screen and (max-width: 960px) {
    .navigation > ul > li > a > span,
    .navigation .center,
    .navigation > ul .li-user .menu,
    .navigation > ul .li-user .avatar,
    .navigation > ul .li-post {
        display: none;
    }

    .mobile {
        display: block;
    }

    .navigation > ul {
        padding-top: 2px;
    }

    .navigation > ul > li {
        width: 20%;
        text-align: center;
    }

    .navigation > ul > li.left:hover a, .navigation > ul > li.left.active a {
        color: #0ae;
        border-bottom: 0px solid;
    }

    .navigation ul li.li-user {
        position: relative;
        float: left;
        margin: 0px;
        padding: 0px;
        text-align: center;
    }

    .navigation ul li.li-user > div {
        margin: 0px auto;
    }

    .navigation ul li.li-user i.mobile {
        position: relative;
        top: 4px;
        font-size: 18px;
        color: #555;
    }

    .navigation ul li.li-user.active, .navigation ul li.li-user.active i.mobile {
        color: #0ae;
    }

    .navigation ul .li-user .menu {
        display: none;
    }

    .navigation .create-tweet {
        position: fixed;
        right: 22px;
        bottom: 15px;
        background: #0ae;
        width: 44px;
        height: 44px;
        border-radius: 100%;
        text-align: center;
        z-index: 100;
        box-shadow: 1px 2px 1px #ccc;
    }

    .navigation .create-tweet i {
        position: relative;
        background: #0ae;
        color: #fff;
        top: 45%;
        transform: translateY(-50%);
        font-size: 20px;
    }

    .tweet .tweetMenu {
        left: -140px
    }

    .tweet .tweetMenu > div {
        left: 152px;
    }
}
</style>
