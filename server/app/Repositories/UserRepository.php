<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * find a user by id
     *
     * @param int $id
     * @return User $user
     */
    public function findById($id)
    {
        $user = User::where('id', $id)->first();

        return $user;
    }

    /**
     * find a user by username
     *
     * @param string $username
     * @return User $user
     */
    public function findByUsername($username)
    {
        $user = User::where('username', $username)->first();

        return $user;
    }

    /**
     * find user's profile
     *
     * @param array $where
     * @param int $authId
     * @return User $user
     */
    public function findProfile($where = [], $authId = 0)
    {
        $profile = User::select(['users.*'])
            // num_tweets: number of tweets for the user
            ->selectRaw('count(distinct t.id) as num_tweets')
            // num_following: number of following for the user
            ->selectRaw('count(distinct f_a.id) as num_following')
            // num_followers: number of followers for the user
            ->selectRaw('count(distinct f_b.id) as num_followers')
            // num_likes: number of likes for the user
            ->selectRaw('count(distinct l.id) as num_likes')
            // is_followed: bool whether the user is followed by auth or not
            ->selectRaw('case when follows.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            // left join tweets for num_tweets
            ->leftJoin('tweets as t', function ($join) {
                $join->on('users.id', '=', 't.user_id')->whereNull('t.deleted_at');
            })->groupBy('users.id')
            // left join follows for num_following
            ->leftJoin('follows as f_a', function ($join) {
                $join->on('users.id', '=', 'f_a.follower_id')->whereNull('f_a.deleted_at');
            })->groupBy('users.id')
            // left join follows for num_followers
            ->leftJoin('follows as f_b', function ($join) {
                $join->on('users.id', '=', 'f_b.followed_id')->whereNull('f_b.deleted_at');
            })->groupBy('users.id')
            // left join follows for num_likes
            ->leftJoin('likes as l', function ($join) {
                $join->on('users.id', '=', 'l.user_id')->whereNull('l.deleted_at');
            })->groupBy('users.id')
            // left join follows for is_followed
            ->leftJoin('follows', function ($join) use ($authId) {
                $join->on('users.id', '=', 'follows.followed_id')->whereNull('follows.deleted_at')
                    ->where('follows.follower_id', $authId);
            })->GroupBy('follows.id')
            ->GroupBy('users.id')->where($where)->first();

        return $profile;
    }

    /**
     * create a new user
     *
     * @param array $data
     * @return User $user
     */
    public function create($data)
    {
        $user = User::create($data);

        return $user;
    }

    /**
     * update the user
     *
     * @param array $data
     */
    public function update($id, $data)
    {
        if (!isset($data['bg'])) unset($data['bg']);
        if (!isset($data['avatar'])) unset($data['avatar']);
        User::where('id', $id)->update($data);
    }
}
