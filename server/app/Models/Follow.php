<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'follows';

    protected $fillable = [
        'follower_id', 'followed_id',
    ];

    public static function getFollowingByUserId($userId, $authId)
    {
        $select = ['u.id', 'u.bg', 'u.avatar', 'u.fullname', 'u.username', 'u.description'];
        $following = self::select($select)
            ->selectRaw('case when follows.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->join('users as u', function ($join) use ($userId) {
                $join->on('follows.followed_id', '=', 'u.id')->whereNull('u.deleted_at')
                    ->where('follows.follower_id', $userId);
            })
            ->OrderBy('follows.updated_at', 'desc')->get();

        return $following;
    }

    public static function getFollowersByUserId($userId, $authId)
    {
        $select = ['u.id', 'u.bg', 'u.avatar', 'u.fullname', 'u.username', 'u.description'];
        $followers = self::select($select)
            ->selectRaw('case when follows.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->join('users as u', function ($join) use ($userId) {
                $join->on('follows.follower_id', '=', 'u.id')->whereNull('u.deleted_at')
                    ->where('follows.followed_id', $userId);
            })
            ->OrderBy('follows.updated_at', 'desc')->get();

        return $followers;
    }
}
