<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Retweet;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : null;

        if (empty($authId)) {
            // get the timeline for public
            $tweets = Tweet::getTweets();
            $retweets = Retweet::getRetweets();
            $tweets = $tweets->concat($retweets);
            $tweets = $tweets->sortByDesc('time');
        } else {
            // get the timeline for auth user
            $tweets = collect([]);
        }

        return view('home.home', ['tweets' => $tweets]);
    }
}
