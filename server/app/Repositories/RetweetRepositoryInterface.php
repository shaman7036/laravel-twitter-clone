<?php

namespace App\Repositories;

interface RetweetRepositoryInterface
{
    public function getRetweetedUsersForTweet($tweetId, $authId = 0);

    public function save($tweetId, $authId);
}
