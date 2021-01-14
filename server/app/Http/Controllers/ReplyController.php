<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Tweet;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('reply_to')) {
            $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : 0;
            $replyIds = Reply::where('reply_to', $request->input('reply_to'))->pluck('reply_id')->toArray();
            $replies = Tweet::getQueryForTweets($authId)->whereIn('tweets.id', $replyIds)->get();
        }

        return response()->json(['replies' => $replies]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->session()->get('auth')) return view('auth.auth', ['form' => 'login']);
        $auth = $request->session()->get('auth');

        // save as tweet
        $tweet = new Tweet;
        $tweet->user_id = $auth->id;
        $tweet->text = $request->text;
        $tweet->save();

        // save ids
        $reply = new Reply;
        $reply->reply_id = $tweet->id;
        $reply->reply_to = $request->reply_to;
        $reply->save();

        return redirect('/profile/with_replies/' . $auth->username);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
