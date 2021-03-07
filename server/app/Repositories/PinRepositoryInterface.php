<?php

namespace App\Repositories;

interface PinRepositoryInterface
{
    public function save($authId, $tweetId);
}
