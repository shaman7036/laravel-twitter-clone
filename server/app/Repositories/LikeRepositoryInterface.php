<?php

namespace App\Repositories;

interface LikeRepositoryInterface
{
    public function getLikedUsersForTweet($tweetId, $authId = 0);

    public function save($tweetId, $authId);
}
