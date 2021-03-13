<?php

namespace App\Repositories;

use App\Models\Follow;

class FollowRepository implements FollowRepositoryInterface
{
    /**
     * get following ids
     *
     * @param int $followerId
     * @return int[] $userIds
     */
    public function getFollowingIds($followerId)
    {
        $userIds = Follow::where('follower_id', $followerId)->pluck('followed_id')->toArray();

        return $userIds;
    }

    /**
     * get the following by user id
     *
     * @param int $userId
     * @param int $authId
     * @param object $pagination
     * @return User[] $users
     */
    public function getFollowingByUserId($userId, $authId, $pagination)
    {
        $users = $this->getQueryForFollowing($userId, $authId)
            ->orderBy('follows.updated_at', 'desc')
            ->offset($pagination->per_page * ($pagination->current_page - 1))
            ->limit($pagination->per_page)
            ->get();

        return $users;
    }

    /**
     * get the followers by user id
     *
     * @param int $userId
     * @param int $authId
     * @param object $pagination
     * @return User[] $users
     */
    public function getFollowersByUserId($userId, $authId, $pagination)
    {
        $users = $this->getQueryForFollowers($userId, $authId)
            ->orderBy('follows.updated_at', 'desc')
            ->offset($pagination->per_page * ($pagination->current_page - 1))
            ->limit($pagination->per_page)
            ->get();

        return $users;
    }

    /**
     * count the following by user id
     *
     * @param int $userId
     * @return int $number
     */
    public function countFollowingByUserId($userId)
    {
        $number = $this->getQueryForFollowing($userId)->count();

        return $number;
    }

    /**
     * count the followers by user id
     *
     * @param int $userId
     * @return int $number
     */
    public function countFollowersByUserId($userId)
    {
        $number = $this->getQueryForFollowers($userId)->count();

        return $number;
    }

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

    /**
     * get a query for the following by user id
     *
     * @param int $userId
     * @param int $authId
     * @return Follow $query
     */
    protected function getQueryForFollowing($userId, $authId = 0)
    {
        $select = ['u.id', 'u.bg', 'u.avatar', 'u.fullname', 'u.username', 'u.description'];
        $query = Follow::select($select)
            ->selectRaw('case when follows.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->join('users as u', function ($join) use ($userId) {
                $join->on('follows.followed_id', '=', 'u.id')->whereNull('u.deleted_at')
                    ->where('follows.follower_id', $userId);
            });

        return $query;
    }

    /**
     * get a query for the followers by user id
     *
     * @param int $userId
     * @param int $authId
     * @return Follow $query
     */
    protected function getQueryForFollowers($userId, $authId = 0)
    {
        $select = ['u.id', 'u.bg', 'u.avatar', 'u.fullname', 'u.username', 'u.description'];
        $query = Follow::select($select)
            ->selectRaw('case when follows.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->join('users as u', function ($join) use ($userId) {
                $join->on('follows.follower_id', '=', 'u.id')->whereNull('u.deleted_at')
                    ->where('follows.followed_id', $userId);
            });

        return $query;
    }
}
