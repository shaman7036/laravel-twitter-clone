<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * get a query to retrieve the pins for the user
     */
    public function pins()
    {
        return $this->hasMany(Pin::class, 'user_id', 'id');
    }

    /**
     * get a user's profile
     *
     * @param array $where
     * @param int $authId
     * @return User $profile
     */
    public static function getProfile($where = [], $authId = 0)
    {
        $profile = self::select(['users.*'])
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
}
