<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Repositories\UserRepositoryInterface;

class SearchController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
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
        $hashtags = array();
        $texts = Tweet::where('text', 'like', '%#' . $q . '%')
            ->orderBy('updated_at', 'desc')->limit(100)->pluck('text')->toArray();
        foreach ($texts as $text) {
            preg_match('/(#' . $q . '\b)|(#' . $q . '\w+)/', $text, $matches);
            if (!$matches) continue;
            if (array_key_exists($matches[0], $hashtags)) {
                $hashtags[$matches[0]] += 1;
            } else {
                $hashtags[$matches[0]] = 1;
            }
        }

        // get users by search query
        $users = $this->userRepository->search($q);

        return response()->json(['hashtags' => $hashtags, 'users' => $users]);
    }
}
