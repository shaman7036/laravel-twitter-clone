<div class='signup'>
    <header>
        <a href='/'><i class='fa fa-twitter'></i></a>
        <h1>Create Your Account</h1>
    </header>
    <form id="form" method="POST" action="{{ URL('/signup') }}"　
        data-parsley-validate
    >
        {{ csrf_field() }}
        <div class="form-group">
        <!-- username -->
        <label>Username: <span id='for_username'></span></label>
        <input class="form-control" id="username" name="username" type="text"
            data-parsley-type="alphanum"
            data-parsley-maxlength="32"
            required
        />
        @if ($errors->has('username'))
            <span class="help-block">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif
        </div>
        <div class="form-group">
        <!-- email -->
        <label>Email address: <span id='for_email'></span></label>
        <input class="form-control" id="email" name='email' type="email"
            data-parsley-type="email"
            data-parsley-maxlength="64"
            required
        />
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        </div>
        <!-- password -->
        <div class="form-group">
        <label>Password: <span id='for_password'></span></label>
        <input class="form-control" id="password" name='password' type="password" value="password"
            data-parsley-maxlength="64"
            data-parsley-minlength="8"
            required
        />
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        </div>
        <!-- password confirmation -->
        <div class="form-group">
        <label>Confirm password: <span id='for_confirmation'></span></label>
        <input class="form-control" id="password_confirmation" name='password_confirmation' type="password" value="password"
            data-parsley-maxlength="64"
            data-parsley-minlength="8"
            required
        />
        </div>
        <!-- submit button -->
        <div class="form-group signup-button">
            <label><span id='for_post' class='msg'></span></label>
            <input class="form-control button" id="submit" value="Sign Up" type="submit" />
        </div>
    </form>
    <div class='to-login'>
        <p>If you have an account, <a href="/login">Log In »</a></p>
    </div>
</div>

<script>
    $('#form').parsley();
</script>
