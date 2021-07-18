<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test GET '/search'
     */
    public function test_search()
    {
        $searchQuery = 'test';

        $response = $this->get('/search?q=' . $searchQuery);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['hashtags', 'users']);
    }
}
