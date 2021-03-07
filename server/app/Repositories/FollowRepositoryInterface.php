<?php

namespace App\Repositories;

interface FollowRepositoryInterface
{
    public function getFollowingIds($followerId);

    public function save($followerId, $followedId);
}
