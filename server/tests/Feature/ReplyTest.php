<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test GET '/replies'
     */
    public function test_index()
    {
        // login
        $auth = (new AuthTest())->logIn($this);

        // create a tweet
        $tweet = (new TweetTest())->createTweet($auth->id);

        // reply to the tweet
        $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
        $this->post('/replies', [
            'reply_to' => $tweet->id,
            'text' => $text,
        ]);

        // index
        $response = $this->get('/replies?reply_to=' . $tweet->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['replies']);
    }

    /**
     * Test POST '/replies'
     */
    public function test_store()
    {
        // login
        $auth = (new AuthTest())->logIn($this);

        // create a tweet
        $tweet = (new TweetTest())->createTweet($auth->id);

        // reply to the tweet
        $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
        $response = $this->post('/replies', [
            'reply_to' => $tweet->id,
            'text' => $text,
        ]);

        $response->assertRedirect('/profile/with_replies/' . $auth->username);
    }
}
