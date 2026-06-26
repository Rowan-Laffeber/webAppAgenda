<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;


class FriendController extends Controller
{
    /**
     * Main friends page
     * Handles tabs: requests / friends / users
     */
    public function index(Request $request)
    {
        // default tab if none selected
        $tab = $request->get('tab', 'requests');

        $incomingRequests = FriendRequest::with('sender')
        ->where('receiver_id', Auth::id())
        ->where('request_status', 'pending')
        ->get();

        $outgoingRequests = FriendRequest::with('receiver')
        ->where('sender_id', Auth::id())
        ->where('request_status', 'pending')
        ->get();

        $friends = Friend::with('friend')
        ->where('user_id', Auth::id())
        ->get();

        return view('friends.index', compact(
            'tab',
            'incomingRequests',
            'outgoingRequests',
            'friends'
        ));
    }

    public function searchFriends(Request $request)
    {
        $search = $request->search;
    
        $friends = Friend::with('friend')
            ->where('user_id', Auth::id())
            ->whereHas('friend', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })
            ->get();
    
        return view('friends.friends-list', compact('friends'));
    }

    public function searchUsers(Request $request)
    {   
        if (empty($request->search)){
            return '';
        }

        $me = Auth::id();

        $users = User::where('name', 'like', '%' . $request->search . '%')
            ->where('id', '!=', Auth::id())
            ->get()
            ->map(function ($user) use ($me) {

                $request = FriendRequest::where(function ($q) use ($me, $user) {
                    $q->where('sender_id', $me)
                      ->where('receiver_id', $user->id);
                })->orWhere(function ($q) use ($me, $user) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $me);
                })->first();
    
                if (!$request) {
                    $user->friend_status = 'none';
                } elseif ($request->request_status === 'accepted') {
                    $user->friend_status = 'friends';
                } elseif ($request->sender_id == $me) {
                    $user->friend_status = 'outgoing';
                } else {
                    $user->friend_status = 'incoming';
                }
    
                return $user;
            });
        
        return view('friends.users-list', compact('users'));
    }

    public function sendRequest(User $user){
        if ($user->id === Auth::id()){
            abort(403);
        }

        $exists = FriendRequest::where(function ($q) use ($user){
            $q->where('sender_id', Auth::id())
            ->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user){
            $q->where('sender_id', $user->id)
            ->where('receiver_id',  Auth::id());
        })->exists();


        if ($exists) {
            return response()->json([
                'success' => false
            ]);
        }

        FriendRequest::Create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'request_status' => 'pending'
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function accept(FriendRequest $request)
    {
        // Only the receiver may accept
        if ($request->receiver_id !== Auth::id()) {
            abort(403);
        }

        // Prevent duplicate friendships
        Friend::firstOrCreate([
            'user_id'   => $request->sender_id,
            'friend_id' => $request->receiver_id,
        ]);

        Friend::firstOrCreate([
            'user_id'   => $request->receiver_id,
            'friend_id' => $request->sender_id,
        ]);

        // Mark request as accepted
        $request->update([
            'request_status' => 'accepted',
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function decline(FriendRequest $request)
    {
        // Only the receiver may decline
        if ($request->receiver_id !== Auth::id()) {
            abort(403);
        }

        $request->update([
            'request_status' => 'declined',
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}