@extends('layouts.app')
@section('content')
<div class="auth">
    <a class="left" href="/home" style="display: inline-block">
        <ul>
            <li>
                <i class="fa fa-search"></i>
                <span>Follow your interests.</span>
            </li>
            <li>
                <i class="fa fa-user-o"></i>
                <span>Hear what people are talking about.</span>
            </li>
            <li>
                <i class="fa fa-comment-o"></i>
                <span>Join the conversation.</span>
            </li>
        </ul>
        <div class="bg"><i class="fa fa-twitter"></i></div>
    </a>
    <div class="right" >
        @if($form === 'signup')
            @include('auth.signup')
        @elseif($form === 'login')
            @include('auth.login')
        @else
        <div class="wrapper">
            <a href="/home"><i class="fa fa-twitter"></i></a>
            <p><a href="/home">See what’s happening in<br /> the world right now</a></p>
            <h1>Join Twitter today.</h1>
            <a class="btn btn-primary to-signup" href="signup">
                Sign Up
            </a>
            <a class="btn btn-default to-login" href="login">
                Log In
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
