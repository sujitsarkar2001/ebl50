<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;

class ExtraController extends Controller
{
    public function viewPage($slug)
    {
        $page = Page::where('slug', $slug)->where('status', true)->firstOrFail();
        return view('user.page', compact('page'));
    }

    // show level
    public function showLevel()
    {
        $elite        = User::where('is_admin', false)->where('level', 'Elite')->count();
        $ex_elite     = User::where('is_admin', false)->where('level', 'Executive Elite')->count();
        $executive    = User::where('is_admin', false)->where('level', 'Executive')->count();
        $si_ex        = User::where('is_admin', false)->where('level', 'Senior Executive')->count();
        $as_mng       = User::where('is_admin', false)->where('level', 'Assistant Manager')->count();
        $manager      = User::where('is_admin', false)->where('level', 'Manager')->count();
        $gn_manager   = User::where('is_admin', false)->where('level', 'General Manager')->count();
        $na_manager   = User::where('is_admin', false)->where('level', 'National Manager')->count();
        $director     = User::where('is_admin', false)->where('level', 'Director')->count();
        $pro_director = User::where('is_admin', false)->where('level', 'Presidential Director')->count();
        $o_c_member   = User::where('is_admin', false)->where('level', 'Owners Club Member')->count();
        $levels = array(
            array('slug' => 'elite','name' => 'Elite', 'members' => $elite),
            array('slug' => 'executive-elite','name' => 'Executive Elite', 'members' => $ex_elite),
            array('slug' => 'executive','name' => 'Executive', 'members' => $executive),
            array('slug' => 'senior-executive','name' => 'Senior Executive', 'members' => $si_ex),
            array('slug' => 'assistant-manager','name' => 'Assistant Manager', 'members' => $as_mng),
            array('slug' => 'manager','name' => 'Manager', 'members' => $manager),
            array('slug' => 'general-manager','name' => 'General Manager', 'members' => $gn_manager),
            array('slug' => 'national-manager','name' => 'National Manager', 'members' => $na_manager),
            array('slug' => 'director','name' => 'Director', 'members' => $director),
            array('slug' => 'presidential-director','name' => 'Presidential Director', 'members' => $pro_director),
            array('slug' => 'owners-club-member','name' => 'Owners Club Member', 'members' => $o_c_member)
        );

        return view('user.level.index', compact('levels'));
    }

    // show level user
    public function showLevelUser($slug)
    {
        $name = str_replace('-', ' ', $slug);

        $users = User::where('is_admin', false)->where('status', true)->where('level', ucwords($name))->where('is_approved', true)->get(['name', 'username', 'level_up_date', 'avatar', 'joining_date']);

        return view('user.level.list', compact('users', 'name'));
    }
}
