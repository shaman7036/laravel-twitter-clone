<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tweet;

class TweetTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test POST '/tweets'
     */
    public function test_store()
    {
        // login
        $auth = (new AuthTest)->logIn($this);

        $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

        $response = $this->post('/tweets', [
            'text' => $text,
        ]);

        $response->assertRedirect('/profile/tweets/' . $auth->username);
    }

    /**
     * Test GET '/tweets/{id}'
     */
    public function test_show()
    {
        $tweetId = 1;

        $response = $this->get('/tweets/' . $tweetId);

        $response->assertJsonStructure(['tweet', 'replies']);
    }

    /**
     * Test DELETE '/tweets/{id}'
     */
    public function test_destroy()
    {
        // login
        $auth = (new AuthTest())->logIn($this);

        // create a tweet
        $tweet = $this->createTweet($auth->id);

        // delete
        $response = $this->delete('/tweets/' . $tweet->id);

        $response->assertStatus(200);
    }

    /**
     * Create a tweet
     * 
     * @return Tweet $tweet
     */
    public function createTweet($userId)
    {
        $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

        $tweet = new Tweet;
        $tweet->user_id = $userId;
        $tweet->text = $text;
        $tweet->save();

        return $tweet;
    }
}
