<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\TweetRepositoryInterface;
use App\Repositories\FollowRepositoryInterface;
use App\Repositories\LikeRepositoryInterface;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    protected $userRepository;
    protected $tweetRepository;
    protected $followRepository;
    protected $likeRepository;

    public function __construct(
        UserRepositoryInterface $userRepositoryInterface,
        TweetRepositoryInterface $tweetRepositoryInterface,
        FollowRepositoryInterface $followRepositoryInterface,
        LikeRepositoryInterface $likeRepositoryInterface
    ) {
        $this->userRepository = $userRepositoryInterface;
        $this->tweetRepository = $tweetRepositoryInterface;
        $this->followRepository = $followRepositoryInterface;
        $this->likeRepository = $likeRepositoryInterface;
    }

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
        $user = $this->userRepository->findByUsername($username);

        return view('profile.edit_profile', ['profile' => $user]);
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

        // get user to update
        $user = $this->userRepository->findByUsername($username);
        if (!isset($user)) {
            return view('profile.edit_profile', [], 402);
        }

        // return error if auth id and user id are not the same
        if ($authId !== $user->id) {
            return view('profile.edit_profile', [], 402);
        }

        // upload bg
        $bg = $request->file('bg') !== null ? $request->file('bg') : null;
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
            $bg = $ext;
        }

        // upload avatar
        $avatar = $request->file('avatar') !== null ? $request->file('avatar') : null;
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
            $avatar = $ext;
        }

        // update user data
        $this->userRepository->update($user->id, [
            'email' => $request->email,
            'fullname' => $request->fullname,
            'description' => $request->description,
            'location' => $request->location,
            'website' => $request->website,
            'bg' => $bg,
            'avatar' => $avatar,
        ]);

        // update auth data in session
        $auth = $this->userRepository->findProfile(['users.id' => $user->id]);
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

        // get pagination object
        $pagination = $request->get('pagination');
        $pagination->link = $link;

        // get auth id
        $authId = $request->get('auth_id');

        // get a profile by username
        $profile = $this->userRepository->findProfile(['users.username' => $username], $authId);

        // get pinned tweets
        $pinnedTweets = collect();
        if ($pagination->current_page == 1) {
            $pinnedTweetIds = $profile->pins()->orderBy('updated_at', 'desc')->pluck('tweet_id')->toArray();
            if (count($pinnedTweetIds) > 0) {
                $pinnedTweets = $this->tweetRepository->getPinnedTweets($pinnedTweetIds, $authId);
            }
        }

        // count tweets and retweets by profile id, and set number in pagination
        $pagination->total = $this->tweetRepository->countTweetsAndRetweets([$profile->id], $pinnedTweetIds, $withReplies);

        // get tweets and retweets by profile id
        $tweets = $this->tweetRepository->getTweetsAndRetweetsForProfile($profile->id, $authId, $pinnedTweetIds, $withReplies, $pagination);

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
        // get pagination object
        $pagination = $request->get('pagination');
        $pagination->link = '/profile/following/' . $username;

        // get auth id
        $authId = $request->get('auth_id');

        // get a profile by username
        $profile = $this->userRepository->findProfile(['users.username' => $username], $authId);

        // count total follownig in profile
        $pagination->total = $this->followRepository->countFollowingByUserId($profile->id);

        // get following in profile
        $users = $this->followRepository->getFollowingByUserId($profile->id, $authId, $pagination);

        return view('profile.profile', ['profile' => $profile, 'users' => $users, 'pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getFollowers(Request $request, $username)
    {
        // get pagination object
        $pagination = $request->get('pagination');
        $pagination->link = '/profile/followers/' . $username;

        // get auth id
        $authId = $request->get('auth_id');

        // get a profile by username
        $profile = $this->userRepository->findProfile(['users.username' => $username], $authId);

        // count total followers in profile
        $pagination->total = $this->followRepository->countFollowersByUserId($profile->id);

        // get followers in profile
        $users = $this->followRepository->getFollowersByUserId($profile->id, $authId, $pagination);

        return view('profile.profile', ['profile' => $profile, 'users' => $users, 'pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @param string $username
     */
    public function getLikes(Request $request, $username)
    {
        // get pagination object
        $pagination = $request->get('pagination');
        $pagination->link = '/profile/likes/' . $username;

        // get auth id
        $authId = $request->get('auth_id');

        // get a profile by username
        $profile = $this->userRepository->findProfile(['users.username' => $username], $authId);

        // set number of profile likes in pagination
        $pagination->total = $profile->num_likes;

        // get liked tweets by profile id
        $tweets = $this->likeRepository->getLikedTweetsForUser($profile->id, $authId, $pagination);

        return view('profile.profile', ['profile' => $profile, 'tweets' => $tweets, 'pagination' => $pagination]);
    }
}
