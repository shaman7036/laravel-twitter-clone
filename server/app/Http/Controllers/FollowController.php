<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FollowRequest;
use App\Models\Follow;

class FollowController extends Controller
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
    public function store(FollowRequest $request)
    {
        $authId = $request->get('auth_id');

        // return error, if auth id and request id are the same
        if ($authId == $request->followed_id) {
            return response()->json([], 400);
        }

        $follow = Follow::withTrashed()
            ->where(['follower_id' => $authId, 'followed_id' => $request->followed_id])->first();
        $isFollowed = false;

        if (!isset($follow)) {
            // new follow
            $follow = new Follow;
            $follow->follower_id = $authId;
            $follow->followed_id = $request->followed_id;
            $follow->save();
            $isFollowed = true;
        } else {
            if ($follow->deleted_at) {
                // follow again
                $follow->deleted_at = null;
                $follow->save();
                $isFollowed = true;
            } else {
                // unfollow
                $follow->delete();
            }
        }

        return response()->json(['isFollowed' => $isFollowed], 200);
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
