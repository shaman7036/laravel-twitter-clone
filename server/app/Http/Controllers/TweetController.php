<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TweetRequest;
use App\Repositories\TweetRepositoryInterface;

class TweetController extends Controller
{
    protected $tweetRepository;

    public function __construct(TweetRepositoryInterface $tweetRepositoryInterface)
    {
        $this->tweetRepository = $tweetRepositoryInterface;
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
     * @param  App\Http\Requests\TweetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TweetRequest $request)
    {
        $this->tweetRepository->save($request->get('auth_id'), $request->text);

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
        $tweet = $this->tweetRepository->findById($id, $authId);
        $replies = $this->tweetRepository->getRepliesForTweet($id, $authId);

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
        $deleted = $this->tweetRepository->delete($id, $authId);

        if (!$deleted) {
            // unauthorized
            return response()->json([], 401);
        } else {
            // deleted
            return response()->json([], 200);
        }
    }
}
