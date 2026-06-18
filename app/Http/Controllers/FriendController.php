<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}