<?php

namespace App\Repositories;

interface FollowRepositoryInterface
{
    public function getFollowingIds($followerId);

    public function getFollowingByUserId($userId, $authId, $pagination);

    public function getFollowersByUserId($userId, $authId, $pagination);

    public function countFollowingByUserId($userId);

    public function countFollowersByUserId($userId);
}
