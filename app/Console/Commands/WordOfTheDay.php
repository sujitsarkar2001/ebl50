<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Video;
use Illuminate\Console\Command;

class WordOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Successfully sent daily level bonus to everyone and update video status.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $elite_users           = User::where('level', 'Elite')->where('is_admin', false)->get();
        $executive_elite_users = User::where('level', 'Executive Elite')->where('is_admin', false)->get();
        $executive_users       = User::where('level', 'Executive')->where('is_admin', false)->get();
        

        foreach ($elite_users as $user) {

            $amount = setting('level_one_bonus');
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);
        }

        foreach ($executive_elite_users as $user) {

            $amount = setting('level_two_bonus');
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);
        }

        foreach ($executive_users as $user) {

            $amount = setting('level_three_bonus');
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);
        }


        // Update Video Status
        $videos = Video::where('status', true)->get();

        foreach ($videos as $video) {
            $video->status = false;
            $video->save();
        }

        $this->info($this->description.' '.$elite_users->count());
    }
}
