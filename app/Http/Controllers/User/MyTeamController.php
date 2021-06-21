<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class MyTeamController extends Controller
{
    public function index()
    {
        return view('user.team.index');
    }

    // Tree view data show
    public function treeView()
    {
        $member = auth()->user();
        return view('user.team.tree', compact('member'));
    }

    // Tree view data show by ID
    public function treeViewById($username)
    {
        $member = User::where('username', $username)->firstOrFail();
        return view('user.team.tree', compact('member'));
    }

    // List view sponsor data show
    public function listView()
    {
        return view('user.team.list-view');
    }

    public function profile($username)
    {
        $member = User::where('username', $username)->firstOrFail();
        return view('user.team.profile', compact('member'));
    }
}
