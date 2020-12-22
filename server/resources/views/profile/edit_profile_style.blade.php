<style>
.edit-profile {
    position: relative;
}
.edit-profile .mobile {
    dislay: none;
}
.edit-profile .bg {
    position: relative;
    width: 100%;
    height: auto;
    background: #888;
    margin-top: 46px;
    padding-top: 25%;
    overflow: hidden;
}
.edit-profile .bg img, .edit-profile .bg input {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
}
.edit-profile .bg img {
    height: auto;
    opacity: 0.5;
}
.edit-profile .bg input {
    opacity: 0;
}
.edit-profile .bg .message {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: inline-block;
    text-align: center;
    top: 200px;
    color: #fff;
}
.edit-profile .bg .message i {
    font-size: 38px;
    margin-bottom: 7.5px;
}
.edit-profile .bg .message span {
    font-size: 20px;
    font-weight: bold;
}
.edit-profile .nav {
    position: relative;
    width: 100%;
    height: 60px;
    top: 0px;
    background: #fff;
    box-shadow: 1px 2px 1px #ddd;
    z-index: 100;
}
.edit-profile .nav > div {
    position: relative;
}
.edit-profile .nav .avatar {
    position: absolute;
    width: 210px;
    height: 210px;
    left: 0px;
    top: -105px;
    border: 5px solid #fff;
    border-radius: 100%;
    z-index: 101;
    background: #888;
    text-align: center;
    overflow: hidden;
}
.edit-profile .nav .avatar img, .edit-profile .nav .avatar input {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
}
.edit-profile .nav .avatar img {
    opacity: 0.5;
}
.edit-profile .nav .avatar input  {
    opacity: 0;
}
.edit-profile .nav .avatar .message {
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    color: white;
}
.edit-profile .nav .avatar .message i {
    font-size: 38px;
    margin-bottom: 5px;
}
.edit-profile .nav .avatar .message span {
    font-size: 20px;
    font-weight: bold;
}
.edit-profile .nav .button {
    float: right;
    min-width: 105px;
    height: 36px;
    line-height: 20px;
    border-radius: 100px;
    font-weight: bold;
    background: #fff;
    color: #0af;
    border: 1px solid #0af;
    margin-top: 12px;
    margin-left: 15px;
    font-size: 15px;
}
.edit-profile .nav .button:first-child {
    color: #888;
}
.edit-profile .main {
    margin-top: 15px;
    border: 0px solid;
}
.edit-profile .main .left {
    height: auto;
    background: #fff;
    border: 1px solid #ccc;
    margin-top: 45px;
    margin-bottom: 30px;
    padding-top: 10px;
}
.edit-profile .main .left .info label {
    margin: 0px;
    margin-top: 4px;
    margin-bottom: 4px;
    color: #888;
}
.edit-profile .main .left .info input {
    width: 100%;
    height: 32px;
    padding-top: 5px;
}
.edit-profile .main .left .info textarea {
    resize: none;
    height: 200px;
    margin-top: 3.5px;
    margin-bottom: 15px;
    font-size: 14px;
}
</style>
