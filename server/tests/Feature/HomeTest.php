<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test GET '/home'
     */
    public function test_GetTimeline()
    {
        $response = $this->get('/home');

        $response
            ->assertViewIs('home.home')
            ->assertViewHasAll(['tweets', 'pagination', 'hashtag', 'auth', 'users']);
    }

    /**
     * Test GET '/home/hashtag/{hashtag}'
     */
    public function test_GetTimelineForHashtag()
    {
        $hashtag = 'test';

        $response = $this->get('/home/hashtag/' . $hashtag);

        $response
            ->assertViewIs('home.home')
            ->assertViewHasAll(['tweets', 'pagination', 'hashtag', 'auth', 'users']);
    }
}
