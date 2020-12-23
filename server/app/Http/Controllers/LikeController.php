<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LikeRequest;
use Auth;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Like;

class LikeController extends Controller
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
    public function store(LikeRequest $request)
    {
        if (!$request->session()->get('auth')) return view('auth.auth', ['form' => 'login']);
        $auth = $request->session()->get('auth');
        $like = Like::withTrashed()
            ->where(['user_id' => $auth->id, 'tweet_id' => $request->tweet_id])->first();
        $isLiked = false;

        if (!isset($like)) {
            // new like
            $like = new Like;
            $like->user_id = $auth->id;
            $like->tweet_id = $request->tweet_id;
            $like->save();
            $is_liked = true;
        } else {
            if ($like->deleted_at) {
                // like again
                $like->deleted_at = null;
                $like->save();
                $isLiked = true;
            } else {
                // unlike
                $like->delete();
                $isLiked = false;
            }
        }

        return response()->json(['success' => true, 'isLiked' => $isLiked]);
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
