<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{    
    /**
     * show all notice
     *
     * @return void
     */
    public function index()
    {
        $notices = Notice::where('status', true)->get();
        return view('user.notice.index', compact('notices'));
    }
    
    /**
     * details notice by specific
     *
     * @param  mixed $slug
     * @return void
     */
    public function details($slug)
    {
        $notice = Notice::where('slug', $slug)->where('status', true)->firstOrFail();
        return view('user.notice.details', compact('notice'));
    }
}
