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
            // num_likes: number of likes for the tweet
            ->selectRaw('count(distinct l_a.id) as num_likes')
            // num_retweets: number of retweets for the tweet
            ->selectRaw('count(distinct rt_a.id) as num_retweets')
            // num_replies: number of replies for the tweet
            ->selectRaw('count(distinct rp_a.id) as num_replies')
            // is_liked: bool whether the tweet is liked by auth or not
            ->selectRaw('case when l_b.user_id = ' . $authId . ' then 1 else 0 end as is_liked')
            // is_retweeted: bool whether the tweet is retweeted by auth or not
            ->selectRaw('case when rt_b.user_id = ' . $authId . ' then 1 else 0 end as is_retweeted')
            // replying_to: username of the target tweet when the tweet is the reply
            ->selectRaw('case when rp_b.reply_id = tweets.id then u_a.username else "" end as replying_to')
            // reply_to: user id of the target tweet when the tweet is the reply
            ->selectRaw('case when rp_b.reply_id = tweets.id then rp_b.reply_to else 0 end as reply_to')
            // inner join tweets for tweets of likes
            ->join('tweets', function ($join) use ($userId) {
                $join->on('likes.tweet_id', '=', 'tweets.id')->whereNull('tweets.deleted_at')->where('likes.user_id', $userId);
            })
            // inner join users for users of tweets
            ->join('users', function ($join) {
                $join->on('tweets.user_id', '=', 'users.id')->whereNull('users.deleted_at');
            })
            // left join likes for num_likes
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')->whereNull('l_a.deleted_at');
            })->groupBy('likes.id')
            // left join retweets for num_retweets
            ->leftJoin('retweets as rt_a', function ($join) {
                $join->on('tweets.id', '=', 'rt_a.tweet_id')->whereNull('rt_a.deleted_at');
            })->groupBy('likes.id')
            // left join replies for num_replies
            ->leftJoin('replies as rp_a', function ($join) {
                $join->on('tweets.id', '=', 'rp_a.reply_to')->whereNull('rp_a.deleted_at');
            })->groupBy('likes.id')
            // left join likes for is_liked
            ->leftJoin('likes as l_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'l_b.tweet_id')->whereNull('l_b.deleted_at')->where('l_b.user_id', $authId);
            })->groupBy('l_b.id')
            // left join retweets for is_retweeted
            ->leftJoin('retweets as rt_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'rt_b.tweet_id')->whereNull('rt_b.deleted_at')->where('rt_b.user_id', $authId);
            })->groupBy('rt_b.id')
            // left join replies for the target tweet's id when the tweet is the reply
            ->leftJoin('replies as rp_b', function ($join) {
                $join->on('tweets.id', '=', 'rp_b.reply_id')->whereNull('rp_b.deleted_at');
            })->groupBy('rp_b.id')
            // left join tweets for the target tweet
            ->leftJoin('tweets as t_a', function ($join) {
                $join->on('rp_b.reply_to', '=', 't_a.id')->whereNull('t_a.deleted_at');
            })->groupBy('t_a.id')
            // left join users for the target tweet's username and user id (replying_to and reply_to)
            ->leftJoin('users as u_a', function ($join) {
                $join->on('t_a.user_id', '=', 'u_a.id')->whereNull('u_a.deleted_at');
            })->groupBy('u_a.id');

        return $query;
    }
}
