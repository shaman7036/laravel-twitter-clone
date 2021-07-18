<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        // migrate
        Artisan::call('migrate:refresh');

        // create default users
        $password = Hash::make('password');

        User::insert([
            'username' => 'auth',
            'email' => 'auth@example.com',
            'password' => $password,
        ]);

        User::insert([
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => $password,
        ]);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test POST '/signup'
     */
    public function test_signUp()
    {
        $username = 'test';
        $email = 'test@example.com';
        $password = 'password';
        $password_confirmation = 'password';

        $response = $this->post('/signup', [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
        ]);

        $response->assertRedirect('/profile/tweets/' . $username);
    }

    /**
     * Test POST '/login'
     */
    public function test_logIn()
    {
        $this->logIn($this);
    }

    /**
     * Test GET '/logout'
     */
    public function test_logOut()
    {
        $this->logIn($this);

        $response = $this->get('/logout');

        $response
            ->assertSessionMissing('auth')
            ->assertRedirect('/login');
    }

    /**
     * Log in
     * 
     * @return User $auth
     */
    public function logIn(TestCase $testCase)
    {
        $username = 'auth';
        $password = 'password';

        // log in
        $response = $testCase->post('/login', [
            'username' => $username,
            'password' => $password,
        ]);

        $response
            ->assertSessionHas('auth')
            ->assertRedirect('/profile/tweets/' . $username);

        $auth = User::where('username', $username)->first();

        return $auth;
    }
}
