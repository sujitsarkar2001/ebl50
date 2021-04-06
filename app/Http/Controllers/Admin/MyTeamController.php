<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class MyTeamController extends Controller
{
    // 
    public function treeView()
    {
        return view('admin.team.tree');
    }

    // Tree view data show by ID
    public function treeViewById($id)
    {
        $user = User::findOrFail($id);
        return view('admin.team.tree-by-id', compact('user'));
    }

    // List view sponsor data show 
    public function listView()
    {
        return view('admin.team.list-view');
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('admin.team.profile', compact('user'));
    }
}
