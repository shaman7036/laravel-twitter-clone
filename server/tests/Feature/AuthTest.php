<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

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
        $username = 'test';
        $email = 'test@example.com';
        $password = 'password';
        $password_hash = Hash::make($password);

        // create auth user if not exists
        if (User::where('email', $email)->exists()) {
            User::where('email', $email)->update([
                'username' => $username,
                'password' => $password_hash,
            ]);
        } else {
            User::insert([
                'username' => $username,
                'email' => $email,
                'password' => $password_hash,
            ]);
        }

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
