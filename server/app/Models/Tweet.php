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
            ->selectRaw('count(distinct l_a.id) as num_likes')
            ->selectRaw('count(distinct r_a.id) as num_retweets')
            ->selectRaw('count(distinct replies.id) as num_replies')
            ->selectRaw('case when l_b.user_id = ' . $authId . ' then 1 else 0 end as is_liked')
            ->selectRaw('case when r_b.user_id = ' . $authId . ' then 1 else 0 end as is_retweeted')
            ->join('users as u', function ($join) {
                $join->on('tweets.user_id', '=', 'u.id')->whereNull('u.deleted_at');
            })
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')->whereNull('l_a.deleted_at');
            })->groupBy('tweets.id')
            ->leftJoin('retweets as r_a', function ($join) {
                $join->on('tweets.id', '=', 'r_a.tweet_id')->whereNull('r_a.deleted_at');
            })->groupBy('tweets.id')
            ->leftJoin('replies', function ($join) {
                $join->on('tweets.id', '=', 'replies.reply_to')->whereNull('replies.deleted_at');
            })->groupBy('tweets.id')
            ->leftJoin('likes as l_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'l_b.tweet_id')->whereNull('l_b.deleted_at')->where('l_b.user_id', $authId);
            })->groupBy('l_b.id')
            ->leftJoin('retweets as r_b', function ($join) use ($authId) {
                $join->on('tweets.id', '=', 'r_b.tweet_id')->whereNull('r_b.deleted_at')->where('r_b.user_id', $authId);
            })->groupBy('r_b.id');

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
            ->selectRaw('count(distinct l_a.id) as num_likes')
            ->selectRaw('count(distinct r_a.id) as num_retweets')
            ->selectRaw('count(distinct replies.id) as num_replies')
            ->selectRaw('case when l_b.user_id = ' . $authId . ' then 1 else 0 end as is_liked')
            ->selectRaw('case when r_b.user_id = ' . $authId . ' then 1 else 0 end as is_retweeted')
            ->join('retweets', function ($join) {
                $join->on('tweets.id', '=', 'retweets.tweet_id')->whereNull('retweets.deleted_at');
            })
            ->join('users as u_t', function ($join) {
                $join->on('tweets.user_id', '=', 'u_t.id')->whereNull('u_t.deleted_at');
            })
            ->join('users as u_r', function ($join) {
                $join->on('retweets.user_id', '=', 'u_r.id')->whereNull('u_r.deleted_at');
            })
            ->leftJoin('likes as l_a', function ($join) {
                $join->on('tweets.id', '=', 'l_a.tweet_id')->whereNull('l_a.deleted_at');
            })->groupBy('retweets.id')
            ->leftJoin('retweets as r_a', function ($join) {
                $join->on('tweets.id', '=', 'r_a.tweet_id')->whereNull('r_a.deleted_at');
            })->groupBy('retweets.id')
            ->leftJoin('replies', function ($join) {
                $join->on('tweets.id', '=', 'replies.reply_to')->whereNull('replies.deleted_at');
            })->groupBy('tweets.id')
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
     * get number of tweets and retweets
     *
     * @param array $userIds
     * @return DB $query
     */
    public static function countTweetsAndRetweets($userIds = [])
    {
        $query_t = self::select('tweets.id');
        $query_r = self::select('tweets.id')
            ->join('retweets', function ($join) {
                $join->on('tweets.id', '=', 'retweets.tweet_id')->whereNull('retweets.deleted_at');
            });
        if (!empty($userIds)) {
            $query_t->whereIn('tweets.user_id', $userIds);
            $query_r->whereIn('retweets.user_id', $userIds);
        }
        $query_t->unionAll($query_r);

        return $query_t->count();
    }
}
