<?php

namespace App\Repositories;

use App\Models\Retweet;

class RetweetRepository extends AbstractRepository implements RetweetRepositoryInterface
{
    protected $model = 'App\Models\Retweet';

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
}
