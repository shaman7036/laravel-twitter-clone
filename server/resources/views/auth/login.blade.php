<div class='login'>
    <header>
        <a href='/home'><i class='fa fa-twitter'></i></a>
        <h1>Log In to Twitter</h1>
    </header>
    <form method="POST" action="{{ URL('/login') }}"
        data-parsley-validate
    >
        {{ csrf_field() }}
        <!-- username -->
        <div class="form-group">
        <label>Username:</label>
        <input class="form-control" id="username" name="username" type="text"
            data-parsley-type="alphanum"
            data-parsley-maxlength="16"
            required
        />
        @if ($errors->has('username'))
            <span class="help-block">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif
        </div>
        <!-- password -->
        <div class="form-group">
        <label>Password:</label>
        <input class="form-control" id="password" name="password" type="password"
            data-parsley-type="password"
            data-parsley-maxlength="64"
            required
        />
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif
        </div>
        <!-- subit button -->
        <div class="form-group">
            <label class='msg'></label>
            <input class="form-control button" id="login" value="Log In" type="submit" />
        </div>
    </form>
    <!-- to signup -->
    <div class='to-signup'>
        <p>New to Twitter? <span onclick='switchForm("signup")'>Sign up now »</span></p>
    </div>
</div>

<style>
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
    color: #0ae;
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
    color: #09e;
    border: 1px solid  #09e;
    font-weight: bold;
    margin-top: 15px;
    padding-top: 3px;
}

.login .message {
    color: #f00;
}

.login .to-signup p span {
    color: #1da1f2;
    cursor: pointer;
}

strong {
    color: #f00;
}
</style>
