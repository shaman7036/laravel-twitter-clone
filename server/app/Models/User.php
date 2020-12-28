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
     * get a user's profile
     *
     * @param array $where
     * @param int $authId
     * @return User $profile
     */
    public static function getProfile($where = [], $authId = 0)
    {
        $profile = self::select(['users.*'])
            ->selectRaw('count(distinct t.id) as num_tweets')
            ->selectRaw('count(distinct f_a.id) as num_following')
            ->selectRaw('count(distinct f_b.id) as num_followers')
            ->selectRaw('count(distinct l.id) as num_likes')
            ->selectRaw('case when follows.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->leftJoin('tweets as t', function ($join) {
                $join->on('users.id', '=', 't.user_id')->whereNull('t.deleted_at');
            })
            ->leftJoin('follows as f_a', function ($join) {
                $join->on('users.id', '=', 'f_a.follower_id')->whereNull('f_a.deleted_at');
            })
            ->leftJoin('follows as f_b', function ($join) {
                $join->on('users.id', '=', 'f_b.followed_id')->whereNull('f_b.deleted_at');
            })
            ->leftJoin('likes as l', function ($join) {
                $join->on('users.id', '=', 'l.user_id')->whereNull('l.deleted_at');
            })
            ->leftJoin('follows', function ($join) use ($authId) {
                $join->on('users.id', '=', 'follows.followed_id')->whereNull('follows.deleted_at')
                    ->where('follows.follower_id', $authId);
            })->GroupBy('follows.id')
            ->GroupBy('users.id')->where($where)->first();

        return $profile;
    }
}
