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
    top: 150px;
    width: 610px;
    animation-delay: 0s;
    animation-duration: 0.25s;
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

.tweet-details-dialog .modal-body .avatar {
    position: absolute;
    left: 15px;
    top: 15px;
    width: 32px;
    height: 32px;
    border: 1px solid #ccc;
    border-radius: 100%;
    background: #eee;
    overflow: hidden;
    text-align: center;
    padding-top: 5px;
}

.tweet-details-dialog .modal-body .avatar i {
    font-size: 32px;
    color: #888;
}

.tweet-details-dialog .modal-body .avatar img {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
}

.tweet-details-dialog .modal-body .textarea {
    position: relative;
    max-width: 100%;
    height: 80px;
    padding-left: 44px;
}

.tweet-details-dialog .modal-body .textarea textarea {
    height: 80px;
    resize: none;
    font-size: 14px;
}

.tweet-details-dialog .modal-body .links {
    display: block;
    height: 50px;
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
    position: relative;
    display: block;
    padding: 0px;
    border-top: 0px solid;
}

.tweet-details-dialog .modal-footer > div {
    position: relative;
    display: block;
    width: 100%;
    height: 44px;
    top: -15px;
}

.tweet-details-dialog .modal-footer .icons {
    position: absolute;
    width: 100%;
    padding-left: 60px;
    margin-top: 7.5px;
}

.tweet-details-dialog .modal-footer .icons li {
    display: inline-block;
    float: left;
    font-size: 21px;
    color: #888;
    padding-left: 15px;
    padding-right: 15px;
}

.tweet-details-dialog .modal-footer .button {
    position: relative;
    float: right;
    border-radius: 30px;
    top: 15px;
    height: 34px;
    line-height: 17px;
    opacity: 0.5;
    margin-right: 15px;
    padding: 0px 15px;
}

.tweet-details-dialog .modal-footer .add-button {
    background: #fff;
    color: #888;
    width: 34px;
    text-align: center;
    padding: 0px;
}

.tweet-details-dialog .modal-footer .add-button i {
    position: relative;
    top: 0px;
    width: 32px;
}

.tweet-details-dialog .modal-footer .tweet-button {
    font-weight: bold;
    background: #0ae !important;
    border-color: #0ae !important;
}

.tweet-details-dialog .modal-footer .add-button.active,
.tweet-details-dialog .modal-footer .tweet-button.active {
    opacity: 1;
}

.tweet-details-dialog .modal-footer .message {
    white-space: nowrap;
    padding-right: 15px;
    height: auto !important;
    left: 0px;
    color: red;
    border: 0px solid;
    text-align: right;
}
</style>
