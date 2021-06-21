<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DailyIncome;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyWorkController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return back();
        }
        $videos = Video::where('status', true)->get();

        $ids = array();
        foreach ($videos as $key => $video) {
            $id = DailyIncome::where('user_id', auth()->id())
                            ->where('video_id', $video->id)
                            ->where('date', date('Y-m-d'))
                            ->first();
            if (isset($id)) {
                array_push($ids, $id->video_id);
            } 
        }

        $notWatchedVideos = Video::where('status', true)
                            ->whereNotIn('id', $ids)
                            ->get();
        
        return view('user.daily-work.index', compact('notWatchedVideos'));
    }

    public function showAddIncomeVideo(Request $request, $slug, $id)
    {
        if (!$request->ajax()) {
            return back();
        }
        $video = Video::where('id', $id)->where('slug', $slug)->firstOrFail();
        
        return view('user.daily-work.add-income', compact('video'));
    }

    // Add income in user account
    public function addIncomeInUserAccount(Request $request, $slug, $id)
    {
        if (!$request->ajax()) {
            return back();
        }
        
        $video = Video::where('id', $id)->where('slug', $slug)->firstOrFail();

        $user = Auth::user();

        $check = DailyIncome::where('user_id', $user->id)
                            ->where('video_id', $video->id)
                            ->where('date', date('Y-m-d'))
                            ->first();
            
        if ($check) {
            $error = 'Oops!!, Something wrong, please try again';
            return view('user.daily-work.index', compact('notWatchedVideos', 'error'));
        
        }
        DailyIncome::create([
            'user_id'  => $user->id,
            'video_id' => $video->id,
            'amount'   => $video->rate,
            'date'     => date('Y-m-d'),
            'month'    => date('F'),
            'year'     => date('Y')
        ]);
        $user->videos()->attach($video->id);
        $user->incomeBalance->update([
            'amount' => $user->incomeBalance->amount + $video->rate
        ]);

        // Using send compact data
        $videos = Video::where('status', true)->get();
        $ids = array();
        foreach ($videos as $data) {
            $id = DailyIncome::where('user_id', auth()->id())->where('video_id', $data->id)->where('date', date('Y-m-d'))->first();
            if (isset($id)) {
                array_push($ids, $id->video_id);
            } 
        }
        $notWatchedVideos = Video::where('status', true)->whereNotIn('id', $ids)->get();
        // End Using send compact data
        
        $success = 'Congratulations, Successfully view video and earn amount added your account';
        return view('user.daily-work.index', compact('notWatchedVideos', 'success'));
 
    }
}
