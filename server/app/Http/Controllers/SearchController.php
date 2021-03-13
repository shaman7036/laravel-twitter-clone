<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TweetRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class SearchController extends Controller
{
    protected $tweetRepository;
    protected $userRepository;

    public function __construct(
        TweetRepositoryInterface $tweetRepositoryInterface,
        UserRepositoryInterface $userRepositoryInterface
    ) {
        $this->tweetRepository = $tweetRepositoryInterface;
        $this->userRepository = $userRepositoryInterface;
    }

    /**
     * get hashtags and users by the search query
     *
     * @param Request $request
     * @return JSON ['hashtags', 'users']
     */
    function search(Request $request)
    {
        if (!$request->input('q')) {
            return response()->json(['hashtags' => [], 'users' => []]);
        }
        $q = $request->input('q');

        // get hashtags by search query
        $hashtags = $this->tweetRepository->searchHashtags($q);

        // get users by search query
        $users = $this->userRepository->search($q);

        return response()->json(['hashtags' => $hashtags, 'users' => $users]);
    }
}
