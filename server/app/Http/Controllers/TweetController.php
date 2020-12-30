<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TweetRequest;
use App\Models\Tweet;
use App\Models\Reply;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TweetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TweetRequest $request)
    {
        if (!$request->session()->get('auth')) return view('auth.auth', ['form' => 'login']);
        $auth = $request->session()->get('auth');
        $tweet = new Tweet;
        $tweet->user_id = $auth->id;
        $tweet->text = $request->text;
        $tweet->save();

        return redirect('/profile/tweets/' . $auth->username);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : 0;
        $tweet = Tweet::getQueryForTweets($authId)->where('tweets.id', $id)->first();
        $replyIds = Reply::where('reply_to', $id)->pluck('reply_id')->toArray();
        $replies = Tweet::getQueryForTweets($authId)->whereIn('tweets.id', $replyIds)->get();

        return response()->json(['tweet' => $tweet, 'replies' => $replies]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->session()->get('auth')) return view('auth.auth', ['form' => 'login']);
        $auth = $request->session()->get('auth');

        $tweet = Tweet::findOrFail($id);

        if ($auth->id != $tweet->user_id) {
            return response()->json(['success' => false], 402);
        } else {
            // delete tweet
            $tweet->delete();
            return response()->json(['success' => true], 200);
        }
    }
}
