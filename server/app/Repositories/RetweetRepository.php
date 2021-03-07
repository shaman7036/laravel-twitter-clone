<?php

namespace App\Repositories;

use App\Models\Retweet;

class RetweetRepository implements RetweetRepositoryInterface
{
    /**
     * get retweeted users for the tweet
     *
     * @param int $tweetId
     * @param int $authId
     * @return Retweet[] $retweetedUsers
     */
    public function getRetweetedUsersForTweet($tweetId, $authId = 0)
    {
        $select = [
            'u.id as user_id', 'u.avatar', 'u.fullname', 'u.username', 'u.description',
        ];
        $retweetedUsers = Retweet::select($select)
            ->selectRaw('case when f.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->join('users as u', function ($join) use ($tweetId) {
                $join->on('retweets.user_id', '=', 'u.id')->whereNull('u.deleted_at')->where('retweets.tweet_id', $tweetId);
            })
            ->leftJoin('follows as f', function ($join) use ($authId) {
                $join->on('u.id', '=', 'f.followed_id')->whereNull('f.deleted_at')->where('f.follower_id', $authId);
            })->groupBy('f.id')->groupBy('retweets.id')
            ->orderBy('retweets.updated_at', 'desc')->get();

        return $retweetedUsers;
    }

    /**
     * retweet or unretweet the tweet
     *
     * @param int $authId
     * @param int $tweetId
     * @return bool $isRetweeted
     */
    public function save($tweetId, $authId = 0)
    {
        $retweet = Retweet::withTrashed()
            ->where(['user_id' => $authId, 'tweet_id' => $tweetId])->first();
        $isRetweeted = false;

        if (!isset($retweet)) {
            // new retweet
            $retweet = new Retweet;
            $retweet->user_id = $authId;
            $retweet->tweet_id = $tweetId;
            $retweet->save();
            $isRetweeted = true;
        } else {
            if ($retweet->deleted_at) {
                // retweet again
                $retweet->deleted_at = null;
                $retweet->save();
                $isRetweeted = true;
            } else {
                // unretweet
                $retweet->delete();
                $isRetweeted = false;
            }
        }

        return $isRetweeted;
    }
}
