<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'likes';

    protected $fillable = [
        'user_id', 'tweet_id',
    ];

    public static function getLikedTweetsByUserId($userId, $authId)
    {
        $select = [
            'tweets.*',
            'u.avatar', 'u.fullname', 'u.username',
        ];
        $tweets = self::select($select)
            ->selectRaw('count(distinct l_a.id) as num_likes')
            ->selectRaw('case when l_b.user_id = ' . $authId . ' then 1 else 0 end as is_liked')
            ->selectRaw('count(distinct r_a.id) as num_retweets')
            ->selectRaw('case when r_b.user_id = ' . $authId . ' then 1 else 0 end as is_retweeted')
            ->join('tweets', function ($join) use ($userId) {
                $join->on('likes.tweet_id', '=', 'tweets.id')
                    ->whereNull('tweets.deleted_at')
                    ->where('tweets.user_id', $userId);
            })
            ->join('users as u', function ($join) {
                $join->on('tweets.user_id', '=', 'u.id')
                    ->whereNull('u.deleted_at');
            })
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')
                    ->whereNull('l_a.deleted_at');
            })->groupBy('likes.id')
            ->leftJoin('likes as l_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'l_b.tweet_id')
                    ->whereNull('l_b.deleted_at')
                    ->where('l_b.user_id', $authId);
            })->groupBy('l_b.id')
            ->leftJoin('retweets as r_a', function ($join) {
                $join->on('tweets.id', '=', 'r_a.tweet_id')
                    ->whereNull('r_a.deleted_at');
            })->groupBy('likes.id')
            ->leftJoin('retweets as r_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'r_b.tweet_id')
                    ->whereNull('r_b.deleted_at')
                    ->where('r_b.user_id', $authId);
            })->groupBy('r_b.id')
            ->orderBy('likes.updated_at', 'desc')->get();

        return $tweets;
    }
}
