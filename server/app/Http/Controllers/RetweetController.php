<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RetweetRequest;
use App\Repositories\RetweetRepositoryInterface;

class RetweetController extends Controller
{
    protected $retweetRepository;

    public function __construct(RetweetRepositoryInterface $retweetRepositoryInterface)
    {
        $this->retweetRepository = $retweetRepositoryInterface;
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
        $retweetedUsers = $this->retweetRepository->getRetweetedUsersForTweet($tweetId, $authId);

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

        // retweet or unretweet the tweet
        $isRetweeted = $this->retweetRepository->createOrToggleActivity([
            'user_id' => $authId,
            'tweet_id' => $request->tweet_id,
        ]);

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
