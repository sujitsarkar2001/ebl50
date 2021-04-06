<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class MyTeamController extends Controller
{
    // Tree view data show
    public function treeView()
    {
        return view('user.team.tree');
    }

    // Tree view data show by ID
    public function treeViewById($id)
    {
        $user = User::findOrFail($id);
        return view('user.team.tree-by-id', compact('user'));
    }

    // List view sponsor data show 
    public function listView()
    {
        return view('user.team.list-view');
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('user.team.profile', compact('user'));
    }
}
