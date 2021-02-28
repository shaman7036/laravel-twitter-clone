<?php

namespace App\Repositories;

interface TweetRepositoryInterface
{
    public function findById($tweetId, $authId = 0);

    public function getRepliesForTweet($tweetId, $authId = 0);

    public function getPinnedTweets($pinnedTweetIds, $authId = 0);

    public function getTweetsAndRetweetsForProfile($userId, $authId, $pinnedTweetIds, $withReplies, $pagination);

    public function getTweetsAndRetweetsForTimeline($userIds, $authId, $pagination);

    public function countTweetsAndRetweets($userIds = [], $notIn = [], $withReplies = true);

    public function save($authId, $text);

    public function delete($tweetId, $authId);
}
