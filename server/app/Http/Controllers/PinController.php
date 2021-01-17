<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pin;
use App\Models\Tweet;

class PinController extends Controller
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
    public function store(Request $request)
    {
        $authId = $request->get('auth_id');

        // check the auth owns the target tweet
        if (!Tweet::where(['user_id' => $authId, 'id' => $request->tweet_id])->exists()) {
            return response()->json([], 400);
        }

        // check the current number of pins in the profile
        $num_pins = Pin::where('user_id', $authId)->count();
        $isExceeded = $num_pins >= env('PINS_PER_PROFILE', 1) ? true : false;

        $pin = Pin::withTrashed()
            ->where(['user_id' => $authId, 'tweet_id' => $request->tweet_id])->first();
        $isPinned = false;

        if (!isset($pin)) {
            if ($isExceeded) {
                // remove the oldest pin to replace
                $oldestPin = Pin::where('user_id', $authId)->orderBy('updated_at', 'asc')->first();
                $oldestPin->delete();
            }
            // new pin
            $pin = new Pin;
            $pin->user_id = $authId;
            $pin->tweet_id = $request->tweet_id;
            $pin->save();
            $isPinned = true;
        } else {
            if ($pin->deleted_at) {
                if ($isExceeded) {
                    // remove the oldest pin to replace
                    $oldestPin = Pin::where('user_id', $authId)->orderBy('updated_at', 'asc')->first();
                    $oldestPin->delete();
                }
                // pin again
                $pin->deleted_at = null;
                $pin->save();
                $isPinned = true;
            } else {
                // unpin
                $pin->delete();
                $isPinned = false;
            }
        }
        $unpinnedTweetId = isset($oldestPin) ? $oldestPin->tweet_id : 0;

        return response()->json(['isPinned' => $isPinned, 'unpinnedTweetId' => $unpinnedTweetId]);
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
