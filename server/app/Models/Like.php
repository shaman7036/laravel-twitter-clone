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
}
