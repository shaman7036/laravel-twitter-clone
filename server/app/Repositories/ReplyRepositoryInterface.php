<?php

namespace App\Repositories;

interface ReplyRepositoryInterface
{
    public function save($tweetId, $replyTo);
}
