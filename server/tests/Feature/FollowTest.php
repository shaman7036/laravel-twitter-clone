<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test POST '/follows'
     */
    public function test_store()
    {
        // login
        $auth = (new AuthTest())->logIn($this);

        // create a tweet
        $tweet = (new TweetTest())->createTweet($auth->id);

        // follow
        $followed_id = 1;
        $response = $this->post('/follows', [
            'followed_id' => $followed_id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isFollowed' => true]);

        // unfollow
        $response = $this->post('/follows', [
            'followed_id' => $followed_id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isFollowed' => false]);
    }
}
