<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class FollowTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test POST '/follows'
     */
    public function test_store()
    {
        // login
        (new AuthTest())->logIn($this);

        // follow
        $user = User::where('username', 'user')->first();
        $response = $this->post('/follows', [
            'followed_id' => $user->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isFollowed' => true]);

        // unfollow
        $response = $this->post('/follows', [
            'followed_id' => $user->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['isFollowed' => false]);
    }
}
