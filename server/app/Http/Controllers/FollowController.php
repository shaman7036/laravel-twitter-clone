<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FollowRequest;
use App\Repositories\FollowRepositoryInterface;

class FollowController extends Controller
{
    protected $followRepository;

    public function __construct(FollowRepositoryInterface $followRepositoryInterface)
    {
        $this->followRepository = $followRepositoryInterface;
    }

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

        // follow or unfollow the user
        $isFollowed = $this->followRepository->createOrToggleActivity([
            'follower_id' => $authId,
            'followed_id' => $request->followed_id,
        ]);

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
