<style>
.mobile {
    display: none;
}

.navigation {
    position: fixed;
    background: #fff;
    border-bottom: 0px solid #ccc;
    box-shadow: 1px 1px 0.5px rgba(0, 0, 0, 0.2);
    z-index: 300;
    width: 100%;
    height: 46px;
    top: 0px;
}

.navigation .left {
    float: left;
}

.navigation .right {
    float: right;
}

.navigation, .navigation > ul {
    width: 100%;
    height: 46px;
}

.navigation > ul {
    position: relative;
    margin: 0 auto;
    max-width: 1150px;
}

.navigation > ul > li {
    height: 46px;
}

.navigation > ul > li.left {
    font-size: 13.5px;
    font-weight: bold;
}

.navigation > ul > li.left a {
    display: inline-block;
    padding: 15px;
    padding-top: 12px;
    padding-bottom: auto;
    height: 46px;
    color: #778;
}

.navigation > ul > li.left:hover a, .navigation > ul > li.left.active a {
    color: #0ae;
    border-bottom: 2px solid #0ae;
}

.navigation > ul > li.left i {
    font-size: 18px;
}

.navigation > ul > li.left span {
    padding-left: 5px;
}

.navigation > ul > li.center {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    padding-top: 7px;
    font-size: 22px;
}

.navigation > ul > li.center i {
    color: #0ae;
    margin-top: 6px;
}

.navigation > ul > li.right {
    margin-left: 8px;
    margin-right: 8px;
    border: 0px solid;
}

.navigation > ul li.right.li-user {
    padding-top: 8px;
}

.navigation ul li.right.li-user > div:first-child {
    width: 30px;
    height: 30px;
    background: #fafafa;
    border: 1px solid #eee;
    border-radius: 100%;
    overflow: hidden;
    text-align: center;
}

.navigation ul li.right.li-user > div:first-child i {
    position: relative;
    top: 5px;
    font-size: 30px;
    color: #888;
}

.navigation > ul li.right.li-user > div:first-child img {
    width: 100%;
    height: 100%;
}

.navigation ul li.right.li-post {
    padding-top: 6px;
    right: 0px;
}

.navigation ul li.right.li-post > div {
    background: #0ae;
    color: #fff;
    padding: 6px 14px;
    border-radius: 30px;
    border: 0px solid;
    font-weight: bold;
    font-size: 14px;
    letter-spacing: 0px;
}

.navigation ul li .spinner_wrapper {
    position: relative;
    display: inline-block;
    left: 0px;
    top: 40%;
    transform: translateY(-50%);
    width: auto;
    height: auto;
}

.navigation ul li .spinner {
    border: 2.5px solid #1da1f2;
    border-top: 2.5px solid #fff;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    animation: spin 1.2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
