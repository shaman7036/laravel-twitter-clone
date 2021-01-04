<div class='login'>
    <header>
        <a href='/'><i class='fa fa-twitter'></i></a>
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
            data-parsley-maxlength="32"
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
            data-parsley-minlength="8"
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
        <p>New to Twitter? <a href="/signup">Sign up now »</a></p>
    </div>
</div>

<script>
    $('#form').parsley();
</script>
