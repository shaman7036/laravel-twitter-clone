<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetweetTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test GET '/retweets'
     */
    public function test_index()
    {
        // login
        $auth = (new AuthTest())->logIn($this);

        // create a tweet
        $tweet = (new TweetTest())->createTweet($auth->id);

        // retweet the tweet
        $response = $this->post('/retweets', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isRetweeted' => true]);

        // index
        $response = $this->get('/retweets', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['users']);
    }

    /**
     * Test POST '/retweets'
     */
    public function test_store()
    {
        // login
        $auth = (new AuthTest())->logIn($this);

        // create a tweet
        $tweet = (new TweetTest())->createTweet($auth->id);

        // retweet
        $response = $this->post('/retweets', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isRetweeted' => true]);

        // unretweet
        $response = $this->post('/retweets', [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isRetweeted' => false]);
    }
}
