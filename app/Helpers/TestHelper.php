<?php

use App\Models\DailyIncome;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Video;

if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function testHelper()
    {
        // $users = App\Models\User::where('is_admin', false)->get();
        // foreach ($users as $user) {
        //     $left   = $user->countLeft();
        //     $middle = $user->countMiddle();
        //     $right  = $user->countRight();

        //     $user->left = $left;
        //     $user->middle = $middle;
        //     $user->right = $right;
        //     $user->save();
        // }

        $user_videos = DB::table('user_video')->get();
        $videos      = Video::get();
        
        foreach ($videos as $video) {
            
            foreach ($video->daily_incomes as $daily_incomes) {
                $daily_incomes->amount = $video->rate;
                $daily_incomes->save();
            }
        }
        // foreach ($user_videos as $video) {

        //     $daily = new DailyIncome();
        //     $daily->user_id = $video->user_id;
        //     $daily->video_id = $video->video_id;
        //     $daily->amount = 0;
            
        //     if ($video->date == '0000-00-00') {
        //         $daily->date  = '2021-03-'.rand(1, 31);
        //         $daily->month = 'March';
        //         $daily->year  = '2021';
        //     } else {
        //         $daily->date  = $video->date;
        //         $daily->month = date('F', strtotime($video->date));
        //         $daily->year  = date('Y', strtotime($video->date));
                
        //     }
        //     $daily->save();
            
        //     // DailyIncome::create([
        //     //     'user_id' => $video->user_id,
        //     //     'video_id'=> $video->video_id,
        //     //     'amount'  => 0,
        //     //     'date'    => $video->date,
        //     //     'month'   => date('F', strtotime($video->date)),
        //     //     'year'    => date('Y', strtotime($video->date))
        //     // ]);
        // }
    }
}
