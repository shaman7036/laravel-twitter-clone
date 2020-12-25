<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Retweet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'retweets';

    protected $fillable = [
        'user_id', 'tweet_id',
    ];

    /**
     * get a query to retrieve retweets
     *
     * @param int $authId
     * @return DB $query
     */
    public static function getRetweetsQuery($authId = 0)
    {
        $select = [
            'retweets.updated_at as time',
            'retweeted_users.username as retweeted_username',
            'tweets.*',
            'u.avatar', 'u.fullname', 'u.username',
        ];
        $query = self::select($select)
            ->selectRaw('count(distinct l_a.id) as num_likes')
            ->selectRaw('count(distinct r_a.id) as num_retweets')
            ->selectRaw('case when l_b.user_id = ' . $authId . ' then 1 else 0 end as is_liked')
            ->selectRaw('case when r_b.user_id = ' . $authId . ' then 1 else 0 end as is_retweeted')
            ->join('users as retweeted_users', function ($join) {
                $join->on('retweets.user_id', '=', 'retweeted_users.id')->whereNull('retweeted_users.deleted_at');
            })
            ->join('tweets', function ($join) {
                $join->on('retweets.tweet_id', '=', 'tweets.id')->whereNull('tweets.deleted_at');
            })
            ->join('users as u', function ($join) {
                $join->on('tweets.user_id', '=', 'u.id')->whereNull('u.deleted_at');
            })
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')->whereNull('l_a.deleted_at');
            })->groupBy('retweets.id')
            ->leftJoin('retweets as r_a', function ($join) {
                $join->on('tweets.id', '=', 'r_a.tweet_id')->whereNull('r_a.deleted_at');
            })->groupBy('retweets.id')
            ->leftJoin('likes as l_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'l_b.tweet_id')->whereNull('l_b.deleted_at')
                    ->where('l_b.user_id', $authId);
            })->groupBy('l_b.id')
            ->leftJoin('retweets as r_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'r_b.tweet_id')->whereNull('r_b.deleted_at')
                    ->where('r_b.user_id', $authId);
            })->groupBy('r_b.id');

        return $query;
    }

    /**
     * get retweets by user ids
     *
     * @param array $userIds
     * @param int $authId
     * @return Retweet $retweets
     */
    public static function getRetweetsByUserIds($userIds = [], $authId = 0)
    {
        $query = self::getRetweetsQuery();
        if (empty($userIds)) {
            $retweets = $query->orderBy('retweets.created_at', 'desc')->get();
        } else {
            $retweets = $query->whereIn('retweets.user_id', $userIds)->orderBy('retweets.created_at', 'desc')->get();
        }

        return $retweets;
    }

    /**
     * get user's retweets
     *
     * @param int $userId
     * @param int $authId
     * @return Retweet $retweets
     */
    public static function getRetweetsByUserId($userId, $authId)
    {
        $query = self::getRetweetsQuery($authId);
        $retweets = $query->where('retweets.user_id', $userId)->orderBy('retweets.created_at', 'desc')->get();

        return $retweets;
    }
}
