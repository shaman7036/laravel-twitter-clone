<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test GET '/likes'
     */
    public function test_index()
    {
        // login
        $auth = (new AuthTest())->logIn($this);

        // create a tweet
        $tweet = (new TweetTest())->createTweet($auth->id);

        // like the tweet
        $response = $this->post('/likes', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isLiked' => true]);

        // index
        $response = $this->get('/likes', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['users']);
    }

    /**
     * Test POST '/likes'
     */
    public function test_store()
    {
        // login
        $auth = (new AuthTest())->logIn($this);

        // create a tweet
        $tweet = (new TweetTest())->createTweet($auth->id);

        // like
        $response = $this->post('/likes', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isLiked' => true]);

        // unlike
        $response = $this->post('/likes', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isLiked' => false]);
    }
}
