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
        $authId = $request->get('auth_id');

        $tweet = new Tweet;
        $tweet->user_id = $authId;
        $tweet->text = $request->text;
        $tweet->save();

        return redirect('/profile/tweets/' . $request->get('auth_username'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $authId = $request->get('auth_id');
        $tweet = Tweet::getQueryForTweets($authId)->where('tweets.id', $id)->first();
        $replies = Tweet::getQueryForTweets($authId)->whereIn('tweets.id', function ($query) use ($id) {
            $query->select('replies.reply_id')->from('replies')
                ->where('replies.reply_to', $id)->whereNull('replies.deleted_at');
        })->orderBy('tweets.updated_at', 'desc')->get();

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
        $authId = $request->get('auth_id');
        $tweet = Tweet::findOrFail($id);

        if ($authId != $tweet->user_id) {
            return response()->json([], 402);
        } else {
            // delete tweet
            $tweet->delete();
            return response()->json([], 200);
        }
    }
}
