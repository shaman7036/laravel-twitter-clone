<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test GET '/profile/edit/{username}'
     */
    public function test_edit()
    {
        $auth = (new AuthTest())->logIn($this);

        $response = $this->get('/profile/edit/' . $auth->username);

        $response
            ->assertViewIs('profile.edit_profile')
            ->assertViewHasAll(['profile']);
    }

    /**
     * Test POST '/profile/edit/{username}'
     */
    public function test_update()
    {
        $auth = (new AuthTest())->logIn($this);
        $avatar = UploadedFile::fake()->image('avatar.jpg');
        $bg = UploadedFile::fake()->image('bg.jpg');

        $response = $this->post('/profile/edit/' . $auth->username, [
            'username' => $auth->username,
            'email' => $auth->email,
            'fullname' => $auth->fullname,
            'description' => $auth->description,
            'location' => $auth->location,
            'website' => $auth->website,
            'avatar' => $avatar,
            'bg' => $bg,
        ]);

        $response->assertRedirect('/profile/tweets/' . $auth->username);

        // delete uploaded images
        $path = storage_path() . '/media/' . $auth->id;
        if (file_exists($path)) {
            array_map('unlink', glob($path . '/avatar/*.*'));
            rmdir($path . '/avatar');
            array_map('unlink', glob($path . '/bg/*.*'));
            rmdir($path . '/bg');
            rmdir($path);
        }
    }

    /**
     * Test GET '/profile/tweets/{username}'
     */
    public function test_getTweets()
    {
        $auth = (new AuthTest())->logIn($this);

        $response = $this->get('/profile/tweets/' . $auth->username);

        $response
            ->assertViewIs('profile.profile')
            ->assertViewHasAll(['profile', 'pinnedTweets', 'tweets', 'pagination']);
    }

    /**
     * Test GET '/profile/with_replies/{username}'
     */
    public function test_getTweetsWithReplies()
    {
        $auth = (new AuthTest())->logIn($this);

        $response = $this->get('/profile/with_replies/' . $auth->username);

        $response
            ->assertViewIs('profile.profile')
            ->assertViewHasAll(['profile', 'pinnedTweets', 'tweets', 'pagination']);
    }

    /**
     * Test GET '/profile/following/{username}'
     */
    public function test_getFollowing()
    {
        $auth = (new AuthTest())->logIn($this);

        $response = $this->get('/profile/following/' . $auth->username);

        $response
            ->assertViewIs('profile.profile')
            ->assertViewHasAll(['profile', 'users', 'pagination']);
    }

    /**
     * Test GET '/profile/followers/{username}'
     */
    public function test_getFollowers()
    {
        $auth = (new AuthTest())->logIn($this);

        $response = $this->get('/profile/followers/' . $auth->username);

        $response
            ->assertViewIs('profile.profile')
            ->assertViewHasAll(['profile', 'users', 'pagination']);
    }

    /**
     * Test GET '/profile/likes/{username}'
     */
    public function test_getLikes()
    {
        $auth = (new AuthTest())->logIn($this);

        $response = $this->get('/profile/likes/' . $auth->username);

        $response
            ->assertViewIs('profile.profile')
            ->assertViewHasAll(['profile', 'tweets', 'pagination']);
    }
}
