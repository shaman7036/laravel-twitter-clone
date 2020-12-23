<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tweets';

    protected $fillable = [
        'id', 'user_id', 'text'
    ];

    protected $attributes = [
        'text' => '',
    ];
}
