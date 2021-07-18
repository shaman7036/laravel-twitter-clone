<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PinTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test POST '/pins'
     */
    public function test_store()
    {
        // login
        $auth = (new AuthTest())->logIn($this);

        // create a tweet
        $tweet = (new TweetTest())->createTweet($auth->id);

        // pin
        $response = $this->post('/pins', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['isPinned', 'unpinnedTweetId'])
            ->assertJson(['isPinned' => true]);

        // unpin
        $response = $this->post('/pins', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['isPinned', 'unpinnedTweetId'])
            ->assertJson(['isPinned' => false]);
    }
}
