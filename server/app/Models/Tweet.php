<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use App\Models\Retweet;
use App\Models\Reply;
use App\Models\Pin;

class Tweet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tweets';

    /**
     * get a query to retrieve the likes for the tweet
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'tweet_id', 'id');
    }

    /**
     * get a query to retrieve the retweets for the tweet
     */
    public function retweets()
    {
        return $this->hasMany(Retweet::class, 'tweet_id', 'id');
    }

    /**
     * get a query to retrieve the replies for the tweet
     */
    public function replies()
    {
        return $this->hasMany(Reply::class, 'reply_id', 'id');
    }

    /**
     * get a query to retrieve the pins for the tweet
     */
    public function pins()
    {
        return $this->hasMany(Pin::class, 'tweet_id', 'id');
    }

    /**
     * delete related retweets and likes when the tweet has been deleted
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($tweet) {
            DB::transaction(function () use ($tweet) {
                $tweet->likes()->delete();
                $tweet->retweets()->delete();
                $tweet->replies()->delete();
                $tweet->pins()->delete();
            });
        });
    }
}
