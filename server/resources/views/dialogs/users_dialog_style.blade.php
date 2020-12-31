<style>
.users-dialog {
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

.users-dialog .wrapper {
    position: relative;
    margin: 0 auto;
    top: 150px;
    width: 610px;
    animation-delay: 0s;
    animation-duration: 0.25s;
    overflow-y: scroll;
}

.users-dialog .modal-header {
    position: sticky;
    top: 0px;
    height: 50px;
    padding: 0px;
    z-index: 10;
    background: #fff;
    border-bottom: 1px solid rgb(235, 238, 240);
}

.users-dialog .modal-header > h3 {
    position: relative;
    text-align: center;
    width: 100%;
    top: -7px;
    font-size: 20px;
    font-weight: bold;
    background: #fff;
}

.users-dialog .modal-header i {
    position: absolute;
    right: 0px;
    top: 0px;
    font-size: 18px;
    padding: 15px;
}

.users-dialog .modal-body {
    padding-top: 0px;
    padding-bottom: 0px;
}

.users-dialog .modal-body .left-col {
    position: relative;
    left: -25px;
}

.users-dialog .users {
    padding: 0px;
}

.users-dialog .users .user {
    border-bottom: 1px solid rgb(235, 238, 240);
    padding: 7.5px 0;
}


.users-dialog .users .user .avatar {
    position: absolute;
    left: 15px;
    top: 0px;
    width: 48px;
    height: 48px;
    border-radius: 100%;
    overflow: hidden;
    background: #eee;
    text-align: center;
    z-index: 1;
}

.users-dialog .users .user .avatar img {
    position: relative;
    width: 100%;
    height: 100%;
}

.users-dialog .users .user .avatar i {
    position: relative;
    font-size: 46px;
    left: 0px;
    top: 12px;
    color: #888;
}

.users-dialog .users .user .fullname {
    font-weight: bold;
}

.users-dialog .users .user .username {
    font-weight: bold;
    color: rgba(0, 0, 0, 0.6);
}

.users-dialog .users .user .description{
    white-space: nowrap;
    text-overflow: ellipsis;
    width: 100%;
    overflow: hidden;
    min-height: 15px;
}

.users-dialog .users .user .follow-button {
    display: inline-block;
    position: absolute;
    border: 1px solid #0ae;
    border-radius: 15px;
    right: 0px;
    top: 3px;
    min-width: 80px;
    height: 30px;
    padding: auto 25px;
    line-height: 16px;
    font-size: 14px;
    font-weight: bold;
    background: #fff;
    color: #0ae;
}

.users-dialog .users .user .follow-button:after {
    content: 'Follow';
}

.users-dialog .users .user .follow-button.active {
    background: #0ae;
    color: #fff;
    border: 0px solid;
}

.users-dialog .users .user .follow-button.active:after {
    content: 'Following';
}

.users-dialog .users .user .follow-button.active:hover {
    background: #f00;
    color: #fff;
}

.users-dialog .users .user .follow-button.active:hover:after {
    content: 'Unfollow';
}

.users-dialog .user-dom-wrapper {
    display: none;
}

.users-dialog .modal-footer {
    text-align: center;
    opacity: 0.6;
    border-top: none;
}
</style>
