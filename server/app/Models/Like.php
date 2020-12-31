<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tweet;

class Like extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'likes';

    protected $fillable = [
        'user_id', 'tweet_id',
    ];

    /**
     * get a query to retrieve the tweet that owns the like
     */
    public function tweet()
    {
        return $this->belongsTo(Tweet::class, 'id', 'tweet_id');
    }

    /**
     * get a query for user's likes
     *
     * @param int $userId
     * @param int $authId
     * @return DB $query
     */
    public static function getQueryForUserLikes($userId, $authId)
    {
        $select = [
            'tweets.id', 'tweets.user_id', 'tweets.text', 'tweets.created_at as time',
            'users.avatar', 'users.fullname', 'users.username',
        ];
        $query = self::select($select)
            ->selectRaw('count(distinct l_a.id) as num_likes')
            ->selectRaw('count(distinct rt_a.id) as num_retweets')
            ->selectRaw('count(distinct rp_a.id) as num_replies')
            ->selectRaw('case when l_b.user_id = ' . $authId . ' then 1 else 0 end as is_liked')
            ->selectRaw('case when rt_b.user_id = ' . $authId . ' then 1 else 0 end as is_retweeted')
            ->selectRaw('case when rp_b.reply_id = tweets.id then u_a.username else "" end as replying_to')
            ->selectRaw('case when rp_b.reply_id = tweets.id then rp_b.reply_to else 0 end as reply_to')
            ->join('tweets', function ($join) use ($userId) {
                $join->on('likes.tweet_id', '=', 'tweets.id')->whereNull('tweets.deleted_at')->where('likes.user_id', $userId);
            })
            ->join('users', function ($join) {
                $join->on('tweets.user_id', '=', 'users.id')->whereNull('users.deleted_at');
            })
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')->whereNull('l_a.deleted_at');
            })->groupBy('likes.id')
            ->leftJoin('retweets as rt_a', function ($join) {
                $join->on('tweets.id', '=', 'rt_a.tweet_id')->whereNull('rt_a.deleted_at');
            })->groupBy('likes.id')
            ->leftJoin('replies as rp_a', function ($join) {
                $join->on('tweets.id', '=', 'rp_a.reply_to')->whereNull('rp_a.deleted_at');
            })->groupBy('likes.id')
            ->leftJoin('likes as l_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'l_b.tweet_id')
                    ->whereNull('l_b.deleted_at')
                    ->where('l_b.user_id', $authId);
            })->groupBy('l_b.id')
            ->leftJoin('retweets as rt_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'rt_b.tweet_id')
                    ->whereNull('rt_b.deleted_at')
                    ->where('rt_b.user_id', $authId);
            })->groupBy('rt_b.id')
            ->leftJoin('replies as rp_b', function ($join) {
                $join->on('tweets.id', '=', 'rp_b.reply_id')->whereNull('rp_b.deleted_at');
            })->groupBy('rp_b.id')
            ->leftJoin('tweets as t_a', function ($join) {
                $join->on('rp_b.reply_to', '=', 't_a.id')->whereNull('t_a.deleted_at');
            })->groupBy('t_a.id')
            ->leftJoin('users as u_a', function ($join) {
                $join->on('t_a.user_id', '=', 'u_a.id')->whereNull('u_a.deleted_at');
            })->groupBy('u_a.id');

        return $query;
    }
}
