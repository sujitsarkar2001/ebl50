<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WordOfTheShare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:share';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Successfully sent share bonus every share package users.';

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
            
            $percentage   = setting('share_package_bonus');
            $total_amount = $user->register_package;

            $amount = round($percentage * ($total_amount / 100), 2);

            if ($total_amount >= setting('share_package')) {
                
                // Insert data to share_incomes table
                $user->shareIncomes()->create([
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
