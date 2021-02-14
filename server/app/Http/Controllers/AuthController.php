<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LogInRequest;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepository = $userRepositoryInterface;
    }

    /**
     * @param App\Http\Requests\SignUpRequest $request
     */
    function signUp(SignUpRequest $request)
    {
        // create a new user
        $user = $this->userRepository->create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'fullname' => 'Name',
        ]);

        // store user data as auth data in session
        $auth = $this->userRepository->findProfile(['users.id' => $user->id]);
        $request->session()->regenerate();
        $request->session()->put('auth', $auth);

        return redirect('/profile/tweets/' . $auth->username);
    }

    /**
     * @param App\Http\Requests\LogInRequest $request
     */
    function logIn(LogInRequest $request)
    {
        // check the password
        $user = $this->userRepository->findByUsername($request->username); // User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->view('auth.auth', [
                'form' => 'login',
                'not_match' => 'The username and password you entered did not match our records. Please double-check and try again.'
            ], 402);
        }

        // store auth data in session
        $auth = $this->userRepository->findById($user->id);
        $request->session()->regenerate();
        $request->session()->put('auth', $auth);

        return redirect('/profile/tweets/' . $auth->username);
    }

    /**
     * @param Illuminate\Http\Request $request
     */
    function logOut(Request $request)
    {
        $request->session()->forget('auth');
        return redirect('/login');
    }
}
