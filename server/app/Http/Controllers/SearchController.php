<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    function search(Request $request)
    {
        $q = $request->input('q');

        $select = [
            'users.id as user_id', 'users.avatar', 'users.fullname', 'users.username',
        ];
        $users = User::select($select)
            ->where('fullname', 'like', '%' . $q . '%')
            ->orWhere('username', 'like', '%' . $q . '%')
            ->orWhere('description', 'like', '%' . $q . '%')
            ->orWhere('location', 'like', '%' . $q . '%')
            ->orderBy('updated_at', 'desc')->limit(100)->get();

        return response()->json(['users' => $users]);
    }
}
