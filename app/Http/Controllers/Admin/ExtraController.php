<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    public function viewPage($slug)
    {
        $page = Page::where('slug', $slug)->where('status', true)->firstOrFail();
        return view('admin.page', compact('page'));
    }
}
