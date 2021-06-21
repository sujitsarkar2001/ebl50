<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
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
        $four_level   = User::where('level', 'Senior Executive')->where('next_level_bonus', date('Y-m-d'))->where('is_admin', false)->get();
        $five_level   = User::where('level', 'Assistant Manager')->where('next_level_bonus', date('Y-m-d'))->where('is_admin', false)->get();
        $six_level    = User::where('level', 'Manager')->where('next_level_bonus', date('Y-m-d'))->where('is_admin', false)->get();
        $seven_level  = User::where('level', 'General Manager')->where('next_level_bonus', date('Y-m-d'))->where('is_admin', false)->get();
        $eight_level  = User::where('level', 'National Manager')->where('next_level_bonus', date('Y-m-d'))->where('is_admin', false)->get();
        $nine_level   = User::where('level', 'Director')->where('next_level_bonus', date('Y-m-d'))->where('is_admin', false)->get();
        $ten_level    = User::where('level', 'Presidential Director')->where('next_level_bonus', date('Y-m-d'))->where('is_admin', false)->get();
        $eleven_level = User::where('level', 'Owners Club Member')->where('next_level_bonus', date('Y-m-d'))->where('is_admin', false)->get();
        
        foreach ($four_level as $user) {
            $amount = setting('level_four_bonus');
            
            // Insert data to level_incomes table
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);

            // Update income_balances table data
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);

            $date = Carbon::create($user->next_level_bonus);
            $next_level_bonus = $date->addDays(30);
            $user->next_level_bonus = date('Y-m-d', strtotime($next_level_bonus));
            $user->save();
            
        }
        
        foreach ($five_level as $user) {
            $amount = setting('level_five_bonus');
            
            // Insert data to level_incomes table
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);

            // Update income_balances table data
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);

            $date = Carbon::create($user->next_level_bonus);
            $next_level_bonus = $date->addDays(30);
            $user->next_level_bonus = date('Y-m-d', strtotime($next_level_bonus));
            $user->save();
            
        }
        
        foreach ($six_level as $user) {
            $amount = setting('level_six_bonus');
            
            // Insert data to level_incomes table
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);

            // Update income_balances table data
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);

            $date = Carbon::create($user->next_level_bonus);
            $next_level_bonus = $date->addDays(30);
            $user->next_level_bonus = date('Y-m-d', strtotime($next_level_bonus));
            $user->save();
            
        }
        
        foreach ($seven_level as $user) {
            $amount = setting('level_seven_bonus');
            
            // Insert data to level_incomes table
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);

            // Update income_balances table data
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);

            $date = Carbon::create($user->next_level_bonus);
            $next_level_bonus = $date->addDays(30);
            $user->next_level_bonus = date('Y-m-d', strtotime($next_level_bonus));
            $user->save();
            
        }
        
        foreach ($eight_level as $user) {
            $amount = setting('level_eight_bonus');
            
            // Insert data to level_incomes table
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);

            // Update income_balances table data
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);

            $date = Carbon::create($user->next_level_bonus);
            $next_level_bonus = $date->addDays(30);
            $user->next_level_bonus = date('Y-m-d', strtotime($next_level_bonus));
            $user->save();
            
        }
        
        foreach ($nine_level as $user) {
            $amount = setting('level_nine_bonus');
            
            // Insert data to level_incomes table
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);

            // Update income_balances table data
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);

            $date = Carbon::create($user->next_level_bonus);
            $next_level_bonus = $date->addDays(30);
            $user->next_level_bonus = date('Y-m-d', strtotime($next_level_bonus));
            $user->save();
            
        }
        
        foreach ($ten_level as $user) {
            $amount = setting('level_ten_bonus');
            
            // Insert data to level_incomes table
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);

            // Update income_balances table data
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);

            $date = Carbon::create($user->next_level_bonus);
            $next_level_bonus = $date->addDays(30);
            $user->next_level_bonus = date('Y-m-d', strtotime($next_level_bonus));
            $user->save();
            
        }
        
        foreach ($eleven_level as $user) {
            $amount = setting('level_eleven_bonus');
            
            // Insert data to level_incomes table
            $user->levelIncomes()->create([
                'amount'     => $amount,
                'date'       => date('Y-m-d'),
                'month'      => date('F'),
                'year'       => date('Y'),
                'level_name' => $user->level
            ]);

            // Update income_balances table data
            $user->incomeBalance()->update([
                'amount' => $user->incomeBalance->amount + $amount
            ]);

            $date = Carbon::create($user->next_level_bonus);
            $next_level_bonus = $date->addDays(30);
            $user->next_level_bonus = date('Y-m-d', strtotime($next_level_bonus));
            $user->save();
            
        }

        $this->info($this->description);
    }
}
