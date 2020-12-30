<style>
.tweet-details-dialog {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0px;
    z-index: 300;
    background: rgba(0, 0, 0, 0.5);
    animation-delay: 0s;
    animation-duration: 0.25s;
}

.tweet-details-dialog .wrapper {
    position: relative;
    margin: 0 auto;
    width: 610px;
    animation-delay: 0s;
    animation-duration: 0.25s;
    overflow-y: scroll;
}

.tweet-details-dialog .modal-header {
    height: 50px;
    padding: 0px;
}

.tweet-details-dialog .modal-header > h3 {
    position: relative;
    text-align: center;
    width: 100%;
    top: -7px;
    font-size: 20px;
    font-weight: bold;
    border: 0px solid;
}

.tweet-details-dialog .modal-header i {
    position: absolute;
    right: 0px;
    top: 0px;
    font-size: 18px;
    padding: 15px;
}

.tweet-details-dialog .modal-body .target .text {
    font-size: 18px;
}

.tweet-details-dialog .modal-body .links {
    display: block;
    height: 50px;
    border-bottom: 1px solid rgb(235, 238, 240);
}

.tweet-details-dialog .modal-body .links > div {
    display: inline-block;
    height: 50px;
    font-size: 15px;
    font-weight: bold;
    padding-left: 20px;
    padding-top: 12px;
}

.tweet-details-dialog .modal-body .links > div > span {
    font-weight: normal;
    opacity: 0.6;
}

.tweet-details-dialog .modal-footer {
    text-align: center;
    opacity: 0.6;
    border-top: none;
}

.tweet-details-dialog .modal-footer:hover {
    background: #fdfdfd;
}
</style>
