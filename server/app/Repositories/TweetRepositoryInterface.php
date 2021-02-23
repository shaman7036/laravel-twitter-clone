<?php

namespace App\Repositories;

interface TweetRepositoryInterface
{
    public function countTweetsAndRetweets($userIds = [], $notIn = [], $withReplies = true);

    public function getPinnedTweets($pinnedTweetIds, $authId = 0);

    public function getTweetsAndRetweetsForProfile($userId, $authId, $pinnedTweetIds, $withReplies, $pagination);

    public function getTweetsAndRetweetsForTimeline($userIds, $authId, $pagination);
}
