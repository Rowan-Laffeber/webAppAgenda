<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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

        return view('friends.index', compact('tab'));
    }

    public function searchUsers(Request $request)
    {   
        if (empty($request->search)){
            return '';
        }
        $users = User::where('name', 'like', '%' . $request->search . '%')
            ->get();
        
        return view('friends.users-list', compact('users'));
    }

    public function sendRequest(User $user){
        if ($user->id === Auth::id()){
            abort(403);
        }
        FriendRequest::firstOrCreate([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
        ]);

        return response()->json([
            'succes' => true
        ]);
    }
}