<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pending = Friend::where([['sender_id', Auth::user()->id], ['is_accepted', 0]])->get();
        $request = Friend::where([['receiver_id', Auth::user()->id], ['is_accepted', 0]])->get();
        $accept = Friend::where([['receiver_id', Auth::user()->id], ['is_accepted', 1]])
                    ->orWhere([['sender_id', Auth::user()->id], ['is_accepted', 1]])
                    ->get();
        return view('friend.index', compact('pending', 'request', 'accept'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|exists:users,username'
        ]);

        $friend = User::where('username', $validated['username'])->first();

        $listed = Friend::where([['sender_id', Auth::user()->id], ['receiver_id', $friend->id]])
            ->orWhere([['receiver_id', Auth::user()->id], ['sender_id', $friend->id]])
            ->get();

        if (count($listed) != 0){
            return redirect()->back()->withErrors($validated['username'] . ' is already on the friend request or friend list.');
        }
        Friend::create([
            'id' => Str::uuid(),
            'sender_id' => Auth::user()->id,
            'receiver_id' => $friend->id,
            'is_accepted' => false
        ]);

        return redirect()->back()->with('success', 'Successfully make a new friend request!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function show(Friend $friend)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friend $friend)
    {
        $friend->update([
            'is_accepted' => true
        ]);

        return redirect()->back()->with('success', 'Action success.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Friend $friend)
    {
        $friend->delete();

        return redirect()->back()->with('success', 'Action success.');
    }
}
