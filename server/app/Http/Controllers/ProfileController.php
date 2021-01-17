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
        // get auth username
        $authUsername = $request->get('auth_username');

        // back to the profile page, if auth is not logged in or auth username and request username are not the same
        if (empty($request->get('auth_username')) || $authUsername != $username) {
            return redirect('/profile/tweets/' . $username);
        }

        // show the edit profile page for auth
        $profile = User::where('username', $authUsername)->first();
        return view('profile.edit_profile', ['profile' => $profile]);
    }

    /**
     * @param UpdateProfileRequest $request
     * @param string $username
     */
    public function update(UpdateProfileRequest $request, $username)
    {
        // get auth id
        $authId = $request->get('auth_id');

        // return error if auth is not logged in
        if (empty($authId)) {
            return view('profile.edit_profile', [], 402);
        }

        // get user to edit
        $user = User::where('username', $username)->first();
        if (!isset($user)) {
            return view('profile.edit_profile', [], 402);
        }

        // return error if auth id and user id are not the same
        if ($authId !== $user->id) {
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
            $dir = 'storage/media/' . $authId . '/bg';
            $files = glob($dir . '/*');
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
            $dir = 'storage/media/' . $authId . '/avatar';
            $ext = $avatar->extension();
            $path = $avatar->move($dir, 'avatar.' . $ext);
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
        if (strrpos($request->fullUrl(), '/profile/with_replies/')) {
            $link = '/profile/with_replies/' . $username;
            $withReplies = true;
        } else {
            $link = '/profile/tweets/' . $username;
            $withReplies = false;
        }

        // create pagination object
        $pagination = (object)[
            'total' => 0,
            'per_page' => env('TWEETS_PER_PAGE', 10),
            'current_page' => $request->input('page') ? $request->input('page') : 1,
            'page_link' => $link,
        ];

        // get auth id
        $authId = $request->get('auth_id');

        // get a profile by username
        $profile = User::getProfile(['users.username' => $username], $authId);

        // get pinned tweets
        $pinnedTweetIds = $profile->pins()->orderBy('updated_at', 'desc')->pluck('tweet_id')->toArray();
        $pinnedTweets = collect();
        if ($pagination->current_page == 1 && count($pinnedTweetIds) > 0) {
            $pinnedTweets = Tweet::getQueryForTweets($authId)
                ->whereIn('tweets.id', $pinnedTweetIds)
                ->orderByRaw('FIELD(tweets.id, ' . implode(',', $pinnedTweetIds) . ')')
                ->get();
        }

        // count tweets and retweets by profile id, and set number in pagination
        $pagination->total = Tweet::countTweetsAndRetweets([$profile->id], $pinnedTweetIds, $withReplies);

        // get tweets and retweets by profile id
        $query_t = Tweet::getQueryForTweets($authId)
            ->where('tweets.user_id', $profile->id)->whereNotIn('tweets.id', $pinnedTweetIds);
        $query_r = Tweet::getQueryForRetweets($authId)
            ->where('retweets.user_id', $profile->id)->whereNotIn('tweets.id', $pinnedTweetIds);
        // make tweets without replies if the url is not with_replies
        if (!$withReplies) {
            $query_t->whereNull('rp_b.id');
        }
        $tweets = $query_t->union($query_r)
            ->orderBy('time', 'desc')
            ->offset($pagination->per_page * ($pagination->current_page - 1))
            ->limit($pagination->per_page)
            ->get();

        return view('profile.profile', [
            'profile' => $profile, 'pinnedTweets' => $pinnedTweets, 'tweets' => $tweets, 'pagination' => $pagination
        ]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getFollowing(Request $request, $username)
    {
        // create pagination object
        $pagination = (object)[
            'total' => 0,
            'per_page' => env('USERS_PER_PAGE', 12),
            'current_page' => $request->input('page') ? $request->input('page') : 1,
            'page_link' => '/profile/following/' . $username,
        ];

        // get auth id
        $authId = $request->get('auth_id');

        // get a profile by username
        $profile = User::getProfile(['users.username' => $username], $authId);

        // count total follownig in profile
        $pagination->total = Follow::getQueryForProfileFollowing($profile->id, $authId)->count();

        // get following in profile
        $users = Follow::getQueryForProfileFollowing($profile->id, $authId)
            ->orderBy('follows.updated_at', 'desc')
            ->offset($pagination->per_page * ($pagination->current_page - 1))
            ->limit($pagination->per_page)
            ->get();

        return view('profile.profile', ['profile' => $profile, 'users' => $users, 'pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getFollowers(Request $request, $username)
    {
        // create pagination object
        $pagination = (object)[
            'total' => 0,
            'per_page' => env('USERS_PER_PAGE', 12),
            'current_page' => $request->input('page') ? $request->input('page') : 1,
            'page_link' => '/profile/followers/' . $username,
        ];

        // get auth id
        $authId = $request->get('auth_id');

        // get a profile by username
        $profile = User::getProfile(['users.username' => $username], $authId);

        // count total followers in profile
        $pagination->total = Follow::getQueryForProfileFollowers($profile->id, $authId)->count();

        // get followers in profile
        $users = Follow::getQueryForProfileFollowers($profile->id, $authId)
            ->orderBy('follows.updated_at', 'desc')
            ->offset($pagination->per_page * ($pagination->current_page - 1))
            ->limit($pagination->per_page)
            ->get();

        return view('profile.profile', ['profile' => $profile, 'users' => $users, 'pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getLikes(Request $request, $username)
    {
        // create pagination object
        $pagination = (object)[
            'total' => 0,
            'per_page' => env('TWEETS_PER_PAGE', 10),
            'current_page' => $request->input('page') ? $request->input('page') : 1,
            'page_link' => '/profile/likes/' . $username,
        ];

        // get auth id
        $authId = $request->get('auth_id');

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
