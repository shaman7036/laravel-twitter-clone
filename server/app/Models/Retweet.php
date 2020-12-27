<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tweet;

class Retweet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'retweets';

    protected $fillable = [
        'user_id', 'tweet_id',
    ];

    /**
     * get a query to retrieve the tweet that owns the retweet
     */
    public function tweet()
    {
        return $this->belongsTo(Tweet::class, 'id', 'tweet_id');
    }
}
