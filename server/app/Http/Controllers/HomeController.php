<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Follow;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * get the timeline for public or auth user
     *
     * @param Request $request
     * @return JSON ['tweets', 'pagination', 'hashtag', 'auth', 'users']
     */
    public function getTimeline(Request $request)
    {
        // get pagination object
        $pagination = $request->get('pagination');
        $pagination->link = '/home';

        // get auth id
        $authId = $request->get('auth_id');

        if (empty($authId)) {
            /**
             * get the timeline for public
             */
            // set number of tweets and retweets in pagination
            $pagination->total = Tweet::countTweetsAndRetweets();
            // get tweets and retweets in all users
            $query_t = Tweet::getQueryForTweets();
            $query_r = Tweet::getQueryForRetweets();
            $tweets = $query_t->union($query_r)
                ->orderBy('time', 'desc')
                ->offset($pagination->per_page * ($pagination->current_page - 1))
                ->limit($pagination->per_page)
                ->get();

            // get users in random order
            $users = User::select(['id', 'username', 'fullname', 'avatar'])
                ->inRandomOrder()->limit(10)->get();
        } else {
            /**
             * get the timeline for auth user
             */
            // get user ids that are followed by auth id
            $userIds = Follow::where('follower_id', $authId)->pluck('followed_id')->toArray();
            // push auth id to user ids
            array_push($userIds, $authId);
            // count tweets and retweets by user ids, and set number in pagination
            $pagination->total = Tweet::countTweetsAndRetweets($userIds);
            // get tweets and retweets by user ids
            $query_t = Tweet::getQueryForTweets($authId)->whereIn('tweets.user_id', $userIds);
            $query_r = Tweet::getQueryForRetweets($authId)->whereIn('retweets.user_id', $userIds);
            $tweets = $query_t->union($query_r)
                ->orderBy('time', 'desc')
                ->offset($pagination->per_page * ($pagination->current_page - 1))
                ->limit($pagination->per_page)
                ->get();

            // get users in random order
            $users = User::select(['users.id', 'users.username', 'users.fullname', 'users.avatar'])
                ->selectRaw('case when f.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
                ->leftJoin('follows as f', function ($join) use ($authId) {
                    $join->on('users.id', '=', 'f.followed_id')->whereNull('f.deleted_at')->where('f.follower_id', $authId);
                })->groupBy('f.id')->groupBy('users.id')
                ->inRandomOrder()->limit(10)->get();
        }

        // get auth profile
        $profile = $authId ? User::getProfile(['users.id' => $authId]) : null;

        return view('home.home', [
            'tweets' => $tweets, 'pagination' => $pagination, 'hashtag' => '',
            'auth' => $profile, 'users' => $users,
        ]);
    }

    /**
     * get the timeline for the hashtag
     *
     * @param Request $request
     * @param String $hashtag
     * @return JSON ['tweets', 'pagination', 'hashtag', 'auth', 'users']
     */
    public function getTimelineForHashtag(Request $request, $hashtag)
    {
        // get pagination object
        $pagination = $request->get('pagination');
        $pagination->link = '/home/hashtag/' . $hashtag;

        // get auth id
        $authId = $request->get('auth_id');

        // set number of tweets that have the hashtag in text
        $pagination->total = Tweet::where('tweets.text', 'like', '%#' . $hashtag . ' %')
            ->orWhere('tweets.text', 'like', '%#' . $hashtag)
            ->count();

        // get tweets
        $tweets = Tweet::getQueryForTweets()->where('tweets.text', 'like', '%#' . $hashtag . ' %')
            ->orWhere('tweets.text', 'like', '%#' . $hashtag)
            ->orderBy('time', 'desc')
            ->offset($pagination->per_page * ($pagination->current_page - 1))
            ->limit($pagination->per_page)
            ->get();

        // get users in random order
        $users = User::select(['users.id', 'users.username', 'users.fullname', 'users.avatar'])
            ->selectRaw('case when f.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->leftJoin('follows as f', function ($join) use ($authId) {
                $join->on('users.id', '=', 'f.followed_id')->whereNull('f.deleted_at')->where('f.follower_id', $authId);
            })->groupBy('f.id')->groupBy('users.id')
            ->inRandomOrder()->limit(10)->get();

        // get auth profile
        $profile = $authId ? User::getProfile(['users.id' => $authId]) : null;

        return view('home.home', [
            'tweets' => $tweets, 'pagination' => $pagination, 'hashtag' => $hashtag,
            'auth' => $profile, 'users' => $users,
        ]);
    }
}
