<?php

namespace App\Repositories;

use App\Models\Reply;

class ReplyRepository implements ReplyRepositoryInterface
{
    /**
     * save tweet id (reply_id) and target id (reply_to)
     *
     * @param int $tweetId
     * @param int $replyTo
     */
    public function save($tweetId, $replyTo)
    {
        $reply = new Reply;
        $reply->reply_id = $tweetId;
        $reply->reply_to = $replyTo;
        $reply->save();
    }
}
