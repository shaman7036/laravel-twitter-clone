<?php

namespace App\Repositories;

use App\Models\Follow;

class FollowRepository implements FollowRepositoryInterface
{
    /**
     * follow or unfollow the user
     *
     * @param int $followerId
     * @param int $followedId
     * @return bool $isFollowed
     */
    public function save($followerId, $followedId)
    {
        $follow = Follow::withTrashed()
            ->where(['follower_id' => $followerId, 'followed_id' => $followedId])->first();
        $isFollowed = false;

        if (!isset($follow)) {
            // new follow
            $follow = new Follow;
            $follow->follower_id = $followerId;
            $follow->followed_id = $followedId;
            $follow->save();
            $isFollowed = true;
        } else {
            if ($follow->deleted_at) {
                // follow again
                $follow->deleted_at = null;
                $follow->save();
                $isFollowed = true;
            } else {
                // unfollow
                $follow->delete();
            }
        }

        return $isFollowed;
    }
}
