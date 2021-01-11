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

    /**
     * get a query for retrieving users who are followed by profile id
     *
     * @param int $userId
     * @param int $authId
     * @return Follow $following
     */
    public static function getQueryForProfileFollowing($profileId, $authId = 0)
    {
        $select = ['u.id', 'u.bg', 'u.avatar', 'u.fullname', 'u.username', 'u.description'];
        $query = self::select($select)
            ->selectRaw('case when follows.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->join('users as u', function ($join) use ($profileId) {
                $join->on('follows.followed_id', '=', 'u.id')->whereNull('u.deleted_at')
                    ->where('follows.follower_id', $profileId);
            });

        return $query;
    }

    /**
     * get a query for retrieving users who are following profile id
     *
     * @param int $userId
     * @param int $authId
     * @return Follow $followers
     */
    public static function getQueryForProfileFollowers($profileId, $authId = 0)
    {
        $select = ['u.id', 'u.bg', 'u.avatar', 'u.fullname', 'u.username', 'u.description'];
        $query = self::select($select)
            ->selectRaw('case when follows.follower_id = ' . $profileId . ' then 1 else 0 end as is_followed')
            ->join('users as u', function ($join) use ($profileId) {
                $join->on('follows.follower_id', '=', 'u.id')->whereNull('u.deleted_at')
                    ->where('follows.followed_id', $profileId);
            });

        return $query;
    }
}
