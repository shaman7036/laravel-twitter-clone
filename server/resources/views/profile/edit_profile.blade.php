@extends('layouts.app')
@section('content')
<?php
    if(isset($profile->bg)) {
        $profile->bg = '/storage/media/'.$profile->id.'/bg/bg.'.$profile->bg;
    }

    if(isset($profile->avatar)) {
        $thumb = '/storage/media/'.$profile->id.'/avatar/thumbnail.'.$profile->avatar;
        $profile->avatar = '/storage/media/'.$profile->id.'/avatar/avatar.'.$profile->avatar;
    }
?>
<form class='edit-profile' method="POST" action={{'/profile/edit/'.$profile->username}} enctype="multipart/form-data">
    {{ csrf_field() }}
    <!-- bg -->
    <div class='bg'>
        <img class='img-bg' src={{$profile->bg}} />
        <div class='message'>
            <i class='fa fa-camera'></i><br />
            <span>Add a header photo</span>
            <input id='input_bg' class='form-control' type='file' name='bg' onchange='changeBg(event)' />
        </div>
    </div>
    <!-- navbar -->
    <div class='nav'>
        <div class='container'>
        <!-- avatar -->
        <div class='avatar'>
            <img class='img-avatar' src={{$profile->avatar}} />
            <div class='message'>
            <i class='fa fa-image'></i><br />
            <span>Change your profile photo</span>
            </div>
            <input id='input_avatar' class='form-control' type='file' name='avatar' onchange='changeAvatar(event)' />
        </div>
        <!-- save button -->
        <input class='button btn btn-default desktop' type='submit' value='Save changes' />
        <input class='button btn btn-default mobile' type='submit' value='Save' />
        <a class='button btn btn-default' href={{'/profile/tweets/'.$profile->username}}>Cancel</a>
    </div>
</div>
<div class='main container'>
    <div class='row'>
        <div class='left col-lg-3'>
            <div class='info'>
                <!-- fullname -->
                <label>Name:</label>
                <input class='name form-control' type='text' name='fullname' value="{{$profile->fullname}}" />
                <!-- username -->
                <label>Username:</label>
                <input class='username form-control' type='text' name='username' value={{$profile->username}} required />
                <!-- email -->
                <label>Email:</label>
                <input class='email form-control' type='text' name='email' value={{$profile->email}} required />
                <!-- location -->
                <label>Location:</label>
                <input class='location form-control' type='text' name='location' value="{{$profile->location}}" />
                <!-- website -->
                <label>Website:</label>
                <input class='url form-control' type='text' name='website' value="{{$profile->website}}" />
                <!-- description -->
                <label>Bio:</label>
                <textarea class='bio form-control' type='text' name='description'>{{$profile->description}}</textarea>
            </div>
        </div>
        </div>
    </div>
</form>

<script>
function changeBg(e) {
    var src = URL.createObjectURL(e.target.files[0]);
    var bg = $('.img-bg');
    bg.attr('src', src);
    var img = new Image();
    img.src = src;
    img.onload = () => {
        if($(window).width() > 1000) {
            if((img.naturalWidth/img.naturalHeight) > 4) {
                bg.css({ width: 'auto', height: '100%' });
            } else {
                bg.css({ width: '125%', height: 'auto' });
            }
        }
    }
}

function changeAvatar(e) {
    this.avatar = e.target.files[0];
    var src = URL.createObjectURL(e.target.files[0]);
    var avatar = $('.img-avatar');
    avatar.attr('src', src);
    var img = new Image();
    img.src = src;
    img.onload = () => {
        var w = img.clientWidth;
        var h = img.clientHeight;
        if(w > h) {
        img.style.width = 'auto';
        img.style.height = '101%';
        var l = -(img.offsetWidth-img.offsetHeight)/2;
        var t = -1;
        } else {
        img.style.width = '101%';
        img.style.height = 'auto';
        var l = -1;
        var t = -(img.offsetHeight-img.offsetWidth)/2;
        }
        img.style.left = l;
        img.style.top = t;
    }
}
</script>
@endsection
