<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LikeRequest;
use App\Repositories\LikeRepositoryInterface;

class LikeController extends Controller
{
    protected $likeRepository;

    public function __construct(LikeRepositoryInterface $likeRepositoryInterface)
    {
        $this->likeRepository = $likeRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authId = $request->get('auth_id');
        $tweetId = $request->input('tweet_id');
        $likedUsers = $this->likeRepository->getLikedUsersForTweet($tweetId, $authId);

        return response()->json(['users' => $likedUsers]);
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
        $authId = $request->get('auth_id');
        $isLiked = $this->likeRepository->save($request->tweet_id, $authId);

        return response()->json(['isLiked' => $isLiked]);
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
