<?php

namespace App\Console\Commands;

use App\Models\LevelIncome;
use Illuminate\Console\Command;

class WordOfTheMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Successfully sent monthly level bonus to everyone.';

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
                
            if ($user->level == 'Senior Executive') {
                $amount = setting('level_four_bonus');
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
            else if ($user->level == 'Assistant Manager') {
                $amount = setting('level_five_bonus');
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
            else if ($user->level == 'Manager') {
                $amount = setting('level_six_bonus');
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
            else if ($user->level == 'General Manager') {
                $amount = setting('level_seven_bonus');
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
            else if ($user->level == 'National Manager') {
                $amount = setting('level_eight_bonus');
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
            else if ($user->level == 'Director') {
                $amount = setting('level_nine_bonus');
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
            else if ($user->level == 'Presidential Director') {
                $amount = setting('level_ten_bonus');
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
            else if ($user->level == 'Owners Club Member') {
                $amount = setting('level_eleven_bonus');
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

        $this->info($this->description);
    }
}
