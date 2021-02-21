<?php

namespace App\Repositories;

interface TweetRepositoryInterface
{
    public function countTweetsAndRetweets($userIds = [], $notIn = [], $withReplies = true);

    public function getPinnedTweets($pinnedTweetIds, $authId = 0);
}
