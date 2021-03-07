<?php

namespace App\Repositories;

use App\Models\Like;
use Illuminate\Support\Facades\DB;

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
}
