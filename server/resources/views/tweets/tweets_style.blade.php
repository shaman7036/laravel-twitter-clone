<style>
.tweets {
    position: relative;
    width: 100%;
    height: 100%;
    top: -1px;
}

.tweets > div {
    background: #fff;
}

.tweets > .header {
    position: relative;
    height: 45px;
    border-bottom: 1px solid #ccc;
}

.tweets > .header > ul {
    position: absolute;
    display: inline-block;
    left: 0px;
    width: auto;
    padding-left: 20px;
}

.tweets > .header > ul > li {
    display: inline-block;
    font-weight: 900;
    font-size: 17px;
    letter-spacing: -0.5px;
    line-height: 46px;
    margin-right: 30px;
    color: #0ae;
}

.tweets > .header > ul > li > a {
    color: #0ae;
}

.tweets > .header > ul > li > a.router-link-exact-active {
    color: #333;
}

.tweets > .header > ul > li > a:hover {
    text-decoration: underline;
}

.tweets > .body {
    height: auto;
}

.tweets > .footer {
    height: 60px;
    text-align: center;
    color: #888;
    line-height: 55px;
}

.tweets > .footer:hover {
    background: #fdfdfd;
}
</style>
