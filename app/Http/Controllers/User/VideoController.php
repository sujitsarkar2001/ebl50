<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserVideo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('status', true)->get();

        $ids = array();
        foreach ($videos as $key => $video) {
            $id = UserVideo::where('user_id', auth()->id())
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

    public function showAddIncomeVideo($slug, $id)
    {
        $video = Video::where('id', $id)->where('slug', $slug)->firstOrFail();
        
        return view('user.daily-work.add-income', compact('video'));
    }

    // Add income in user account
    public function addIncomeInUserAccount($slug, $id)
    {
        $video = Video::where('id', $id)->where('slug', $slug)->first();
        
        if ($video) {

            $user = Auth::user();

            $check = UserVideo::where('user_id', $user->id)
                                ->where('video_id', $video->id)
                                ->where('date', date('Y-m-d'))
                                ->first();
                
            if ($check) {

                return redirect(route('daily.work'))->with('error', 'This video already viewed');
            
            } else {
                UserVideo::create([
                    'user_id'  => $user->id,
                    'video_id' => $video->id,
                    'date'     => date('Y-m-d')
                ]);
                // $user->videos()->attach($video->id);
                $user->incomeBalance->update([
                    'amount' => $user->incomeBalance->amount + $video->rate
                ]);
            }
            return redirect(route('daily.work'))->with('success', 'Your daily income added');
           
        } else {
            return redirect(route('daily.work'))->with('error', 'This video not found');
        }
    }
}
