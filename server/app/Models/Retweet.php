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
