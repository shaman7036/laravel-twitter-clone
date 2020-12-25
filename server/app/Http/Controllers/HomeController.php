<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Retweet;
use App\Models\Follow;
use App\Models\User;

class HomeController extends Controller
{
    public function getTimeline(Request $request)
    {
        $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : 0;

        if (empty($authId)) {
            /**
             * get the timeline for public
             */
            // get tweets and retweets in all users
            $query_t = Tweet::getQueryForTweets();
            $query_r = Tweet::getQueryForRetweets();
            $tweets = $query_t->union($query_r)->orderBy('time', 'desc')->get();

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
            // get tweets and retweets by user ids
            $query_t = Tweet::getQueryForTweets($authId)->whereIn('tweets.user_id', $userIds);
            $query_r = Tweet::getQueryForRetweets($authId)->whereIn('retweets.user_id', $userIds);
            $tweets = $query_t->union($query_r)->orderBy('time', 'desc')->get();

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

        return view('home.home', ['tweets' => $tweets, 'users' => $users, 'auth' => $profile]);
    }
}
