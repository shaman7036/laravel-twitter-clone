<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RetweetRequest;
use App\Models\Retweet;

class RetweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authId = $request->get('auth_id');
        $tweetId = $request->input('tweet_id');

        $select = [
            'u.id as user_id', 'u.avatar', 'u.fullname', 'u.username', 'u.description',
        ];
        $retweetedUsers = Retweet::select($select)
            ->selectRaw('case when f.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
            ->join('users as u', function ($join) use ($tweetId) {
                $join->on('retweets.user_id', '=', 'u.id')->whereNull('u.deleted_at')->where('retweets.tweet_id', $tweetId);
            })
            ->leftJoin('follows as f', function ($join) use ($authId) {
                $join->on('u.id', '=', 'f.followed_id')->whereNull('f.deleted_at')->where('f.follower_id', $authId);
            })->groupBy('f.id')->groupBy('retweets.id')
            ->orderBy('retweets.updated_at', 'desc')->get();

        return response()->json(['users' => $retweetedUsers]);
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
    public function store(RetweetRequest $request)
    {
        $authId = $request->get('auth_id');
        $retweet = Retweet::withTrashed()
            ->where(['user_id' => $authId, 'tweet_id' => $request->tweet_id])->first();
        $isRetweeted = false;

        if (!isset($retweet)) {
            // new retweet
            $retweet = new Retweet;
            $retweet->user_id = $authId;
            $retweet->tweet_id = $request->tweet_id;
            $retweet->save();
            $isRetweeted = true;
        } else {
            if ($retweet->deleted_at) {
                // retweet again
                $retweet->deleted_at = null;
                $retweet->save();
                $isRetweeted = true;
            } else {
                // unretweet
                $retweet->delete();
                $isRetweeted = false;
            }
        }

        return response()->json(['isRetweeted' => $isRetweeted]);
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
    public function destroy($id)
    {
        //
    }
}
