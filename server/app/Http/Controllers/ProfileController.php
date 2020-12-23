<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Models\Tweet;
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

        $user->save();
        return redirect('/profile/tweets/' . $user->username);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getTweets(Request $request, $username)
    {
        $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : null;
        $profile = User::where('username', $username)->first();
        $select = ['tweets.*', 'u.avatar', 'u.fullname', 'u.username'];
        $tweets = Tweet::select($select)
            ->selectRaw('count(distinct l_a.id) as num_likes')
            ->selectRaw('case when l_b.user_id = ' . $authId . ' then 1 else 0 end as is_liked')
            ->join('users as u', function ($join) use ($profile) {
                $join->on('tweets.user_id', '=', 'u.id')
                    ->whereNull('u.deleted_at')
                    ->where('tweets.user_id', $profile->id);
            })
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')
                    ->whereNull('l_a.deleted_at');
            })->groupBy('tweets.id')
            ->leftJoin('likes as l_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'l_b.tweet_id')
                    ->whereNull('l_b.deleted_at')
                    ->where('l_b.user_id', $authId);
            })->groupBy('l_b.id')
            ->orderBy('tweets.created_at', 'desc')->get();

        return view('profile.profile', ['profile' => $profile, 'tweets' => $tweets]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getFollowers(Request $request, $username)
    {
        $profile = User::where('username', $username)->first();
        $users = collect([]);
        return view('profile.profile', ['profile' => $profile, 'users' => $users]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getFollowing(Request $request, $username)
    {
        $profile = User::where('username', $username)->first();
        $users = collect([]);
        return view('profile.profile', ['profile' => $profile, 'users' => $users]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getLikes(Request $req, $username)
    {
        $profile = User::where('username', $username)->first();
        $tweets = collect([]);
        return view('profile.profile', ['profile' => $profile, 'tweets' => $tweets]);
    }
}
