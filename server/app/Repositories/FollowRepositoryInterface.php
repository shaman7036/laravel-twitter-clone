<?php

namespace App\Repositories;

interface FollowRepositoryInterface
{
    public function save($followerId, $followedId);
}
