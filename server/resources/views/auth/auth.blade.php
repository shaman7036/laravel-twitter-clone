@extends('layouts.app')
@section('content')
<div class='auth'>
    <div class='left'>
        <ul>
        <li>
            <i class='fa fa-search'></i>
            <span>Follow your interests.</span>
        </li>
        <li>
            <i class='fa fa-user-o'></i>
            <span>Hear what people are talking about.</span>
        </li>
        <li>
            <i class='fa fa-comment-o'></i>
            <span>Join the conversation.</span>
        </li>
        </ul>
        <div class='bg'><i class='fa fa-twitter'></i></div>
    </div>
    <div class='right' >
        @if($form === 'signup')
        @include('auth.signup')
        @elseif($form === 'login')
        @include('auth.login')
        @else
        <div class='wrapper'>
            <a href='/home'><i class='fa fa-twitter'></i></a>
            <p>See what’s happening in<br /> the world right now</p>
            <h1>Join Twitter today.</h1>
            <button class='btn btn-primary toSignUp' onclick='switchForm("signup")'>Sign Up</button>
            <button class='btn btn-default toLogIn' onclick='switchForm("login")'>Log In</button>
        </div>
        @endif
    </div>
</div>

<script>
function switchForm(name) {
    window.location.href = name;
}
</script>

@include('auth.auth_style');
@include('auth.auth_mobile');
@endsection
