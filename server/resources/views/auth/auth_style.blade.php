<?php
    $twitter_blue = 'rgb(29, 161, 242)';
?>
<style>
.auth {
    position: fixed;
    z-index: 2000;
    width: 100%;
    height: 100%;
    top: 0px;
    background: #fff;
    font-weight: bold !important;
}

.auth > .left, .auth > .right {
    position: absolute;
    display: inline-block;
    width: 50%;
    height: 100%;
    overflow: hidden;
}

.auth > .right {
    left: 50%;
}

.auth > .left {
    background: <?php echo $twitter_blue; ?>;
    left: 0px;
}

.auth > .right {
    background: #fff;
}

.auth .left .bg {
    position: relative;
    top: -25%;
    left: 65%;
    transform: translateX(-50%);
}

.auth .left .bg i {
    font-size: 1200px;
    color: rgb(14, 146, 227);
}

.auth .left ul {
    position: absolute;
    left: 50%;
    top: 35%;
    transform: translate(-50%);
    color: #fff;
    z-index: 2001;
}

.auth .left ul li {
    white-space: nowrap;
}

.auth .left ul li i {
    font-size: 28px;
    margin: 20px 0;
    margin-right: 15px;
}

.auth .left ul li span {
    font-size: 18px;
    font-weight: bold;
}

/* right */
.auth .right {
    border: 0px solid;
}

.auth .right > .wrapper {
    position: absolute;
    display: inline-block;
    left: 25%;
    top: 50%;
    transform: translateX(-50%);
    transform: translateY(-50%);
}

.auth .right > .wrapper > * {
    display: block;
}

.auth .right .wrapper i.fa-twitter {
    font-size: 46px;
    color: <?php echo $twitter_blue; ?>;
    margin-bottom: 7px;
}

.auth .right .wrapper p {
    font-size: 26px;
    line-height: 32px;
    margin-bottom: 45px;
    }

.auth .right .wrapper h1 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 16px;
    }

.auth .right .wrapper .btn {
    display: inline-block;
    border-radius: 30px !important;
    width: 350px;
    height: 32px;
    line-height: 16px;
    font-weight: bold;
    }

.auth .right .wrapper .to-signup {
    margin-bottom: 16px !important;
    border: 0px solid;
}

.auth .right .wrapper .to-signup {
    background: <?php echo $twitter_blue; ?>;
}

.auth .right .wrapper .to-login {
    background: #fff;
    color: <?php echo $twitter_blue; ?>;
}

.signup {
    position: absolute;
    width: 350px;
    left: 25%;
    top: 50%;
    transform: translateX(-50%);
    transform: translateY(-50%);
}

.signup header i {
    font-size: 46px;
    color: <?php echo $twitter_blue; ?>;
    margin-bottom: 7px;
}

.signup h1 {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 32px;
}

.signup label {
}

.signup input {
    border-radius: 30px;
    font-weight: normal;
    padding-top: 5px;
}

.signup input.button {
    background: <?php echo $twitter_blue; ?>;
    color: #fff;
    border: 0px solid;
    font-weight: bold;
    margin-top: 15px;
}

.signup .message {
    color: #f00;
}

.signup .signup-button input {
    padding-top: 3px;
}

.signup .to-login p a {
    color: <?php echo $twitter_blue; ?>;
    cursor: pointer;
}

.login {
    position: absolute;
    width: 350px;
    left: 25%;
    top: 50%;
    transform: translateX(-50%);
    transform: translateY(-50%);
}

.login header i {
    font-size: 46px;
    color: <?php echo $twitter_blue; ?>;
    margin-bottom: 7px;
}

.login h1 {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 32px;
}

.login input {
    border-radius: 30px;
    padding-top: 6px;
}

.login input.button {
    background: #fff;
    color: <?php echo $twitter_blue; ?>;
    border: 1px solid  <?php echo $twitter_blue; ?>;
    font-weight: bold;
    margin-top: 15px;
    padding-top: 3px;
}

.login .message {
    color: #f00;
}

.login .to-signup p a {
    color: <?php echo $twitter_blue; ?>;
    cursor: pointer;
}
strong {
    color: #f00;
}
</style>
