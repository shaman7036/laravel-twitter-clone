<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LogInRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param App\Http\Requests\SignUpRequest $request
     */
    function signUp(SignUpRequest $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->fullname = 'Name';
        $user->save();

        $auth = User::getProfile(['users.id' => $user->id]);
        $request->session()->regenerate();
        $request->session()->put('auth', $auth);

        return redirect('/profile/tweets/' . $auth->username);
    }

    /**
     * @param App\Http\Requests\LogInRequest $request
     */
    function logIn(LogInRequest $request)
    {
        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->view('auth.auth', [
                'form' => 'login',
                'not_match' => 'The username and password you entered did not match our records. Please double-check and try again.'
            ], 402);
        }

        $auth = User::getProfile(['users.id' => $user->id]);
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
