<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PinRepositoryInterface;
use App\Repositories\TweetRepositoryInterface;

class PinController extends Controller
{
    protected $pinRepository;
    protected $tweetRepository;

    public function __construct(
        PinRepositoryInterface $pinRepositoryInterface,
        TweetRepositoryInterface $tweetRepositoryInterface
    ) {
        $this->pinRepository = $pinRepositoryInterface;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authId = $request->get('auth_id');

        // check the auth owns the target tweet
        if (!$this->tweetRepository->exists(['user_id' => $authId, 'id' => $request->tweet_id])) {
            return response()->json([], 400);
        }

        $result = $this->pinRepository->save($authId, $request->tweet_id);

        return response()->json($result);
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
