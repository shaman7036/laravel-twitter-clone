<?php

namespace App\Repositories;

use App\Models\Tweet;

class TweetRepository implements TweetRepositoryInterface
{
    /**
     * get number of tweets and retweets
     *
     * @param array $userIds
     * @param array $notIn (tweet ids)
     * @param bool $withReplies
     * @return int
     */
    public function countTweetsAndRetweets($userIds = [], $notIn = [], $withReplies = true)
    {
        $query_t = Tweet::select('tweets.id', 'replies.reply_id')
            ->leftJoin('replies', function ($join) {
                $join->on('tweets.id', '=', 'replies.reply_id')->whereNull('replies.deleted_at');
            });
        $query_r = Tweet::select('tweets.id')->selectRaw('"" as reply_id')
            ->join('retweets', function ($join) {
                $join->on('tweets.id', '=', 'retweets.tweet_id')->whereNull('retweets.deleted_at');
            });
        if (!empty($userIds)) {
            // to count tweets in user ids
            $query_t->whereIn('tweets.user_id', $userIds);
            $query_r->whereIn('retweets.user_id', $userIds);
        }
        if (!empty($notIn)) {
            // to count tweets not in some tweet ids
            $query_t->whereNotIn('tweets.id', $notIn);
            $query_r->whereNotIn('tweets.id', $notIn);
        }
        if (!$withReplies) {
            // to count tweets without replies
            $query_t->whereNull('replies.reply_id');
        }
        $query_t->unionAll($query_r);

        return $query_t->count();
    }
}
