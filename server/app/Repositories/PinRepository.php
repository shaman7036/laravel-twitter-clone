<?php

namespace App\Repositories;

use App\Models\Pin;
use App\Models\Tweet;

class PinRepository implements PinRepositoryInterface
{
    /**
     * pin or unpin the tweet
     *
     * @param int $authId
     * @param int $tweetId
     * @return object [bool $isPinned, int $unpinnedTweetId]
     */
    public function save($authId, $tweetId)
    {
        // check the current number of pins in the profile
        $num_pins = Pin::where('user_id', $authId)->count();
        $isExceeded = $num_pins >= env('PINS_PER_PROFILE', 1) ? true : false;

        $pin = Pin::withTrashed()
            ->where(['user_id' => $authId, 'tweet_id' => $tweetId])->first();
        $isPinned = false;

        if (!isset($pin)) {
            if ($isExceeded) {
                // remove the oldest pin to replace
                $oldestPin = Pin::where('user_id', $authId)->orderBy('updated_at', 'asc')->first();
                $oldestPin->delete();
            }
            // new pin
            $pin = new Pin;
            $pin->user_id = $authId;
            $pin->tweet_id = $tweetId;
            $pin->save();
            $isPinned = true;
        } else {
            if ($pin->deleted_at) {
                if ($isExceeded) {
                    // remove the oldest pin to replace
                    $oldestPin = Pin::where('user_id', $authId)->orderBy('updated_at', 'asc')->first();
                    $oldestPin->delete();
                }
                // pin again
                $pin->deleted_at = null;
                $pin->save();
                $isPinned = true;
            } else {
                // unpin
                $pin->delete();
                $isPinned = false;
            }
        }
        $unpinnedTweetId = isset($oldestPin) ? $oldestPin->tweet_id : 0;

        return [
            'isPinned' => $isPinned,
            'unpinnedTweetId' => $unpinnedTweetId,
        ];
    }
}
