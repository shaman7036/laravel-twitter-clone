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
        $authId = $request->get('auth_id');
        if (!$request->input('reply_to')) {
            return response()->json([], 400);
        }
        $reply_to = $request->input('reply_to');
        $replies = Tweet::getQueryForTweets($authId)->whereIn('tweets.id', function ($query) use ($reply_to) {
            $query->select('replies.reply_id')->from('replies')
                ->where('replies.reply_to', $reply_to)->whereNull('replies.deleted_at');
        })->orderBy('tweets.updated_at', 'desc')->get();

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
        $authId = $request->get('auth_id');

        // save as tweet
        $tweet = new Tweet;
        $tweet->user_id = $authId;
        $tweet->text = $request->text;
        $tweet->save();

        // save ids
        $reply = new Reply;
        $reply->reply_id = $tweet->id;
        $reply->reply_to = $request->reply_to;
        $reply->save();

        return redirect('/profile/with_replies/' . $request->get('auth_username'));
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
