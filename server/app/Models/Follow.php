<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'follows';

    protected $fillable = [
        'follower_id', 'followed_id',
    ];
}
