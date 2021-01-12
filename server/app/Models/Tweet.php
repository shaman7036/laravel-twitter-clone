<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Retweet;
use App\Models\Like;

class Tweet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tweets';

    /**
     * get a query to retrieve the retweets for the tweet
     */
    public function retweets()
    {
        return $this->hasMany(Retweet::class, 'tweet_id', 'id');
    }

    /**
     * get a query to retrieve the likes for the tweet
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'tweet_id', 'id');
    }

    /**
     * delete related retweets and likes when the tweet has been deleted
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($tweet) {
            DB::transaction(function () use ($tweet) {
                $tweet->retweets()->delete();
                $tweet->likes()->delete();
            });
        });
    }

    /**
     * get a query to retrieve tweets
     *
     * @param int $authId
     * @return DB $query
     */
    public static function getQueryForTweets($authId = 0)
    {
        $select = [
            'tweets.id', 'tweets.user_id', 'tweets.text',
            'tweets.created_at as time',
            'u.avatar', 'u.fullname', 'u.username',
        ];
        $query = self::select($select)->addSelect(DB::raw('"" as retweeted_username'))
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
            // inner join for users of tweets
            ->join('users as u', function ($join) {
                $join->on('tweets.user_id', '=', 'u.id')->whereNull('u.deleted_at');
            })
            // left join likes for num_likes
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')->whereNull('l_a.deleted_at');
            })->groupBy('tweets.id')
            // left join retweets for num_retweets
            ->leftJoin('retweets as rt_a', function ($join) {
                $join->on('tweets.id', '=', 'rt_a.tweet_id')->whereNull('rt_a.deleted_at');
            })->groupBy('tweets.id')
            // left join replies for num_replies
            ->leftJoin('replies as rp_a', function ($join) {
                $join->on('tweets.id', '=', 'rp_a.reply_to')->whereNull('rp_a.deleted_at');
            })->groupBy('tweets.id')
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

    /**
     * get a query to retrieve retweets
     *
     * @param int $authId
     * @return DB $query
     */
    public static function getQueryForRetweets($authId = 0)
    {
        $select = [
            'tweets.id', 'tweets.user_id', 'tweets.text',
            'retweets.updated_at as time',
            'u_t.avatar', 'u_t.fullname', 'u_t.username',
            'u_r.username as retweeted_username',
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
            // inner join retweets for retweetes of tweets
            ->join('retweets', function ($join) {
                $join->on('tweets.id', '=', 'retweets.tweet_id')->whereNull('retweets.deleted_at');
            })
            // inner join users for users of retweets
            ->join('users as u_t', function ($join) {
                $join->on('tweets.user_id', '=', 'u_t.id')->whereNull('u_t.deleted_at');
            })
            // inner join users for retweeted_username
            ->join('users as u_r', function ($join) {
                $join->on('retweets.user_id', '=', 'u_r.id')->whereNull('u_r.deleted_at');
            })
            // left join likes for num_likes
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')->whereNull('l_a.deleted_at');
            })->groupBy('retweets.id')
            // left join retweets for num_retweets
            ->leftJoin('retweets as rt_a', function ($join) {
                $join->on('tweets.id', '=', 'rt_a.tweet_id')->whereNull('rt_a.deleted_at');
            })->groupBy('retweets.id')
            // left join replies for num_replies
            ->leftJoin('replies as rp_a', function ($join) {
                $join->on('tweets.id', '=', 'rp_a.reply_to')->whereNull('rp_a.deleted_at');
            })->groupBy('retweets.id')
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

    /**
     * get number of tweets and retweets
     *
     * @param array $userIds
     * @param array $notIn (tweet ids)
     * @param bool $withReplies
     * @return int
     */
    public static function countTweetsAndRetweets($userIds = [], $notIn = [], $withReplies = true)
    {
        $query_t = self::select('tweets.id', 'replies.reply_id')
            ->leftJoin('replies', function ($join) {
                $join->on('tweets.id', '=', 'replies.reply_id')->whereNull('replies.deleted_at');
            });
        $query_r = self::select('tweets.id')->selectRaw('"" as reply_id')
            ->join('retweets', function ($join) {
                $join->on('tweets.id', '=', 'retweets.tweet_id')->whereNull('retweets.deleted_at');
            });
        if (!empty($userIds)) {
            // to count tweets in user ids
            $query_t->whereIn('tweets.user_id', $userIds);
            $query_r->whereIn('retweets.user_id', $userIds);
        }
        if (!empty($notIn)) {
            // to count tweets not in some tweet ids
            $query_t->whereNotIn('tweets.id', $notIn);
            $query_r->whereNotIn('tweets.id', $notIn);
        }
        if (!$withReplies) {
            // to count tweets without replies
            $query_t->whereNull('replies.reply_id');
        }
        $query_t->unionAll($query_r);

        return $query_t->count();
    }
}
