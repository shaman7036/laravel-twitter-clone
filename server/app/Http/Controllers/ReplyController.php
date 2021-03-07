<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReplyRepositoryInterface;
use App\Repositories\TweetRepositoryInterface;

class ReplyController extends Controller
{
    protected $replyRepository;
    protected $tweetRepository;

    public function __construct(
        ReplyRepositoryInterface $replyRepositoryInterface,
        TweetRepositoryInterface $tweetRepositoryInterface
    ) {
        $this->replyRepository = $replyRepositoryInterface;
        $this->tweetRepository = $tweetRepositoryInterface;
    }

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
        $replies = $this->tweetRepository->getRepliesForTweet($reply_to, $authId);

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
        $tweetId = $this->tweetRepository->save($authId, $request->text);

        // save tweet id and target id (reply_to)
        $this->replyRepository->save($tweetId, $request->reply_to);

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
