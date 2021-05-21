<?php

namespace App\Console\Commands;

use App\Models\LevelIncome;
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
        $users = \App\Models\User::where('is_admin', false)->where('is_approved', true)->get();

        foreach ($users as $user) {

            // $level = level($user);

            if ($user->level == 'Elite') {
                $amount = setting('level_one_bonus');
                // Insert data to level_incomes table
                $user->levelIncomes()->create([
                    'amount' => $amount,
                    'date'   => date('Y-m-d'),
                    'month'  => date('F'),
                    'year'   => date('Y')
                ]);

                // Update income_balances table data
                $user->incomeBalance()->update([
                    'amount' => $user->incomeBalance->amount + $amount
                ]);
            } 
            else if ($user->level == 'Executive Elite') {
                $amount = setting('level_two_bonus');
                // Insert data to level_incomes table
                $user->levelIncomes()->create([
                    'amount' => $amount,
                    'date'   => date('Y-m-d'),
                    'month'  => date('F'),
                    'year'   => date('Y')
                ]);

                // Update income_balances table data
                $user->incomeBalance()->update([
                    'amount' => $user->incomeBalance->amount + $amount
                ]);
            }
            else if ($user->level == 'Executive') {
                $amount = setting('level_three_bonus');
                // Insert data to level_incomes table
                $user->levelIncomes()->create([
                    'amount' => $amount,
                    'date'   => date('Y-m-d'),
                    'month'  => date('F'),
                    'year'   => date('Y')
                ]);

                // Update income_balances table data
                $user->incomeBalance()->update([
                    'amount' => $user->incomeBalance->amount + $amount
                ]);
            }
        }

        // Update Video Status
        $videos = \App\Models\Video::where('status', true)->get();

        foreach ($videos as $video) {
            $video->update([
                'status' => false
            ]);
        }

        $this->info($this->description);
    }
}
