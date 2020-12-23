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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RetweetRequest $request)
    {
        if (!$request->session()->get('auth')) return view('auth.auth', ['form' => 'login']);
        $auth = $request->session()->get('auth');
        $retweet = Retweet::withTrashed()
            ->where(['user_id' => $auth->id, 'tweet_id' => $request->tweet_id])->first();
        $isRetweeted = false;

        if (!isset($retweet)) {
            // new retweet
            $retweet = new Retweet;
            $retweet->user_id = $auth->id;
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

        return response()->json(['success' => true, 'isRetweeted' => $isRetweeted]);
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
