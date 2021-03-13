<?php

namespace App\Repositories;

use App\Models\Like;

class LikeRepository implements LikeRepositoryInterface
{
    /**
     * get liked users for the tweet
     *
     * @param int $tweetId
     * @param int $authId
     * @return Like[] $likedUsers
     */
    public function getLikedUsersForTweet($tweetId, $authId = 0)
    {
        $select = [
            'u.id as user_id', 'u.avatar', 'u.fullname', 'u.username', 'u.description',
        ];
        $likedUsers = Like::select($select)
            ->selectRaw('case when f.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->join('users as u', function ($join) use ($tweetId) {
                $join->on('likes.user_id', '=', 'u.id')->whereNull('u.deleted_at')->where('likes.tweet_id', $tweetId);
            })
            ->leftJoin('follows as f', function ($join) use ($authId) {
                $join->on('u.id', '=', 'f.followed_id')->whereNull('f.deleted_at')->where('f.follower_id', $authId);
            })->groupBy('f.id')->groupBy('likes.id')
            ->orderBy('likes.updated_at', 'desc')->get();

        return $likedUsers;
    }

    /**
     * get liked tweets for the user
     *
     * @param int $userId
     * @param int $authId
     * @param object $pagination
     * @return Like[] $likedTweets
     */
    public function getLikedTweetsForUser($userId, $authId, $pagination)
    {
        $likedTweets = $this->getQueryForUserLikes($userId, $authId)
            ->orderBy('likes.updated_at', 'desc')
            ->offset($pagination->per_page * ($pagination->current_page - 1))
            ->limit($pagination->per_page)
            ->get();

        return $likedTweets;
    }

    /**
     * like or unlike the tweet
     *
     * @param int $authId
     * @param int $tweetId
     * @return bool $isLiked
     */
    public function save($tweetId, $authId)
    {
        $like = Like::withTrashed()
            ->where(['user_id' => $authId, 'tweet_id' => $tweetId])->first();
        $isLiked = false;

        if (!isset($like)) {
            // new like
            $like = new Like;
            $like->user_id = $authId;
            $like->tweet_id = $tweetId;
            $like->save();
            $isLiked = true;
        } else {
            if ($like->deleted_at) {
                // like again
                $like->deleted_at = null;
                $like->save();
                $isLiked = true;
            } else {
                // unlike
                $like->delete();
                $isLiked = false;
            }
        }

        return $isLiked;
    }

    /**
     * get a query for user's likes
     *
     * @param int $userId
     * @param int $authId
     * @return DB $query
     */
    protected function getQueryForUserLikes($userId, $authId)
    {
        $select = [
            'tweets.id', 'tweets.user_id', 'tweets.text', 'tweets.created_at as time',
            'users.avatar', 'users.fullname', 'users.username',
        ];
        $query = Like::select($select)
            // num_likes: number of likes for the tweet
            ->selectRaw('count(distinct l_a.id) as num_likes')
            // num_retweets: number of retweets for the tweet
            ->selectRaw('count(distinct rt_a.id) as num_retweets')
            // num_replies: number of replies for the tweet
            ->selectRaw('count(distinct rp_a.id) as num_replies')
            // is_liked: bool whether the tweet is liked by auth or not
            ->selectRaw('case when l_b.user_id = ' . $authId . ' then 1 else 0 end as is_liked')
            // is_retweeted: bool whether the tweet is retweeted by auth or not
            ->selectRaw('case when rt_b.user_id = ' . $authId . ' then 1 else 0 end as is_retweeted')
            // replying_to: username of the target tweet when the tweet is the reply
            ->selectRaw('case when rp_b.reply_id = tweets.id then u_a.username else "" end as replying_to')
            // reply_to: user id of the target tweet when the tweet is the reply
            ->selectRaw('case when rp_b.reply_id = tweets.id then rp_b.reply_to else 0 end as reply_to')
            // inner join tweets for tweets of likes
            ->join('tweets', function ($join) use ($userId) {
                $join->on('likes.tweet_id', '=', 'tweets.id')->whereNull('tweets.deleted_at')->where('likes.user_id', $userId);
            })
            // inner join users for users of tweets
            ->join('users', function ($join) {
                $join->on('tweets.user_id', '=', 'users.id')->whereNull('users.deleted_at');
            })
            // left join likes for num_likes
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')->whereNull('l_a.deleted_at');
            })->groupBy('likes.id')
            // left join retweets for num_retweets
            ->leftJoin('retweets as rt_a', function ($join) {
                $join->on('tweets.id', '=', 'rt_a.tweet_id')->whereNull('rt_a.deleted_at');
            })->groupBy('likes.id')
            // left join replies for num_replies
            ->leftJoin('replies as rp_a', function ($join) {
                $join->on('tweets.id', '=', 'rp_a.reply_to')->whereNull('rp_a.deleted_at');
            })->groupBy('likes.id')
            // left join likes for is_liked
            ->leftJoin('likes as l_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'l_b.tweet_id')->whereNull('l_b.deleted_at')->where('l_b.user_id', $authId);
            })->groupBy('l_b.id')
            // left join retweets for is_retweeted
            ->leftJoin('retweets as rt_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'rt_b.tweet_id')->whereNull('rt_b.deleted_at')->where('rt_b.user_id', $authId);
            })->groupBy('rt_b.id')
            // left join replies for the target tweet's id when the tweet is the reply
            ->leftJoin('replies as rp_b', function ($join) {
                $join->on('tweets.id', '=', 'rp_b.reply_id')->whereNull('rp_b.deleted_at');
            })->groupBy('rp_b.id')
            // left join tweets for the target tweet
            ->leftJoin('tweets as t_a', function ($join) {
                $join->on('rp_b.reply_to', '=', 't_a.id')->whereNull('t_a.deleted_at');
            })->groupBy('t_a.id')
            // left join users for the target tweet's username and user id (replying_to and reply_to)
            ->leftJoin('users as u_a', function ($join) {
                $join->on('t_a.user_id', '=', 'u_a.id')->whereNull('u_a.deleted_at');
            })->groupBy('u_a.id');

        return $query;
    }
}
