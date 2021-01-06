<style>
.search {
    position: relative;
}

.search > input {
    position: relative;
    top: 7.5px;
    width: 200px;
    height: 30px;
    border-radius: 30px;
    padding-top: 5px;
    box-shadow: 0px 0px 0px rgba(0,0,0,.075);
}

.search > i {
    position: absolute;
    right: 10px;
    top: 15px;
    color: #888;
}

.search .users {
    position: fixed;
    margin-top: 12px;
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
    max-height: 480px;
    overflow-y: scroll;
}

.search .user  {
    cursor: pointer;
    height: 60px;
    padding: 0px auto;
}

.search .user:hover {
    background: #fdfdfd;
}

.search .user .avatar {
    position: absolute;
    display: inline-block;
    width: 40px;
    height: 40px;
    border-radius: 100%;
    overflow: hidden
}

.search .user .avatar img {
    width: 40px;
    height: 40px;
}

.search .user .fullname,
.search .user .username {
    position: relative;
    padding-left: 52px;
    font-weight: bold;
}

.search .user .fullname {
    position: relative;
    top: 0px;
}

.search .user .username {
    position: relative;
    bottom: 4px;
    opacity: 0.6;
}

@media screen and (max-width: 960px) {
    .search {
        display: none;
    }
}
</style>
