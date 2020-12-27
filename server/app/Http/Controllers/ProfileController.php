<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Retweet;
use App\Models\Like;
use App\Models\Follow;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    /**
     * @param Request $request
     * @param string $username
     */
    public function edit(Request $request, $username)
    {
        $auth = $request->session()->get('auth');
        if (!isset($auth) || $username != $auth->username) {
            return redirect('/profile/tweets/' . $username);
        } else {
            $profile = User::where('username', $username)->first();
            return view('profile.edit_profile', ['profile' => $profile]);
        }
    }

    /**
     * @param UpdateProfileRequest $request
     * @param string $username
     */
    public function update(UpdateProfileRequest $request, $username)
    {
        // get auth user
        $auth = $request->session()->get('auth');
        if (!isset($auth) || $username != $auth->username) {
            return view('profile.edit_profile', [], 402);
        }

        // get user to edit
        $user = User::where('username', $username)->first();
        if (!isset($user)) {
            return view('profile.edit_profile', [], 402);
        }

        if ($auth->id !== $user->id) {
            return view('profile.edit_profile', [], 402);
        }

        $user->email = $request->email;
        $user->fullname = $request->fullname;
        $user->description = $request->description;
        $user->location = $request->location;
        $user->website = $request->website;

        // upload bg
        $bg = $request->file('bg');
        if (isset($bg)) {
            $dir = 'storage/media/' . $auth->id . '/bg';
            $files = glob($dir . '/*');
            //error_log('$files='.json_encode($files));
            if (isset($files)) {
                foreach ($files as $f) {
                    unlink($f);
                }
            }
            $ext = $bg->extension();
            $path = $bg->move($dir, 'bg.' . $ext);
            $img = Image::make($path);
            if ($img->height() < $img->width() / 4) {
                $w = null;
                $h = 375;
            } else {
                $w = 1500;
                $h = null;
            }
            $img->resize($w, $h, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->crop(1500, 375, null, 0);
            $img->backup();
            $img->save($dir . '/bg.' . $ext);
            $img->reset();
            $img->resize(400, 100);
            $img->save($dir . '/thumbnail.' . $ext);
            $user->bg = $ext;
        }

        // upload avatar
        $avatar = $request->file('avatar');
        if (isset($avatar)) {
            $dir = 'storage/media/' . $auth->id . '/avatar';
            $ext = $avatar->extension();
            $path = $avatar->move($dir, 'avatar.' . $ext);
            error_log($path);
            $img = Image::make($path);
            if ($img->width() > $img->height()) {
                $w = null;
                $h = 200;
            } else {
                $w = 200;
                $h = null;
            }
            $img->resize($w, $h, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->crop(200, 200);
            $img->backup();
            $img->save($dir . '/avatar.' . $ext);
            $img->reset();
            $img->resize(75, 75);
            $img->save($dir . '/thumbnail.' . $ext);
            $user->avatar = $ext;
        }

        // save profile
        $user->save();

        // update auth data in session
        $auth = User::getProfile(['users.id' => $user->id]);
        $request->session()->put('auth', $auth);

        return redirect('/profile/tweets/' . $user->username);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getTweets(Request $request, $username)
    {
        // create pagination object
        $per_page = 10;
        $pagination = (object)[
            'total' => 0,
            'per_page' => $per_page,
            'current_page' => $request->input('page') ? $request->input('page') : 1,
            'page_link' => '/profile/tweets/' . $username,
        ];

        // get auth id if user is logged in
        $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : 0;

        // get a profile by username
        $profile = User::getProfile(['users.username' => $username], $authId);

        // count tweets and retweets by profile id, and set number in pagination
        $pagination->total = Tweet::countTweetsAndRetweets([$profile->id]);

        // get tweets and retweets by profile id
        $query_t = Tweet::getQueryForTweets($authId)->where('tweets.user_id', $profile->id);
        $query_r = Tweet::getQueryForRetweets($authId)->where('retweets.user_id', $profile->id);
        $tweets = $query_t->union($query_r)
            ->orderBy('time', 'desc')
            ->offset($pagination->per_page * ($pagination->current_page - 1))
            ->limit($pagination->per_page)
            ->get();

        return view('profile.profile', ['profile' => $profile, 'tweets' => $tweets, 'pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getFollowing(Request $request, $username)
    {
        $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : 0;

        // get a profile by username
        $profile = User::getProfile(['users.username' => $username], $authId);

        // get following users by profile id
        $users = Follow::getFollowingByUserId($profile->id, $authId);

        return view('profile.profile', ['profile' => $profile, 'users' => $users]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getFollowers(Request $request, $username)
    {
        $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : 0;

        // get a profile by username
        $profile = User::getProfile(['users.username' => $username], $authId);

        // get following by profile id
        $users = Follow::getFollowersByUserId($profile->id, $authId);

        return view('profile.profile', ['profile' => $profile, 'users' => $users]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getLikes(Request $request, $username)
    {
        // create pagination object
        $per_page = 10;
        $pagination = (object)[
            'total' => 0,
            'per_page' => $per_page,
            'current_page' => $request->input('page') ? $request->input('page') : 1,
            'page_link' => '/profile/likes/' . $username,
        ];

        // get auth id if user is logged in
        $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : 0;

        // get a profile by username
        $profile = User::getProfile(['users.username' => $username], $authId);

        // set number of profile likes in pagination
        $pagination->total = $profile->num_likes;

        // get liked tweets by profile id
        $tweets = Like::getQueryForUserLikes($profile->id, $authId)
            ->orderBy('likes.updated_at', 'desc')
            ->offset($pagination->per_page * ($pagination->current_page - 1))
            ->limit($pagination->per_page)
            ->get();

        return view('profile.profile', ['profile' => $profile, 'tweets' => $tweets, 'pagination' => $pagination]);
    }
}
