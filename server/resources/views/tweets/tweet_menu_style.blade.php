<style>
.tweet-menu {
    position: absolute;
    left: 0px;
    top: 45px;
    display: none;
    border: 1px solid #ccc;
    font-size: 14px;
    padding: 15px;
    background: #fff;
    z-index: 1000;
    border-radius: 4px;
    box-shadow: 0px 3px 4px #ccc;
    color: #262626;
}

.tweet-menu > div {
    position: absolute;
    left: 12px;
    top: -8px;
	width: 0;
	height: 0;
	border-left: 8px solid transparent;
	border-right: 8px solid transparent;
	border-bottom: 8px solid #ccc;
}

.tweet-menu > div > div {
    position: relative;
    left: -8px;
    top: 1px;
	width: 0;
	height: 0;
	border-left: 8px solid transparent;
	border-right: 8px solid transparent;
	border-bottom: 8px solid #fff;
}

.tweet-menu li {
    cursor: pointer;
    white-space: nowrap;
    padding: 5px 0px;
}

.tweet-menu li.pin-tweet:after {
    content: 'Pin to your profile page';
}

.pinned-tweets .tweet-menu li.pin-tweet:after {
    content: 'Unpin from profile';
}

@media screen and (max-width: 960px) {
    .tweet-menu {
        left: auto;
        right: 4px;

    }

    .tweet-menu > div {
        left: auto;
        right: 7.5px;
    }
}
</style>
