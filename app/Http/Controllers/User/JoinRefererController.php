<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GenerationIncome;
use App\Models\SponsorIncome;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JoinRefererController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return back();
        }
        return view('user.join-member');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'placement_id'        => 'nullable|numeric',
            'direction'           => 'required|numeric',
            'name'                => 'required|string|max:50',
            'username'            => 'required|string|max:25|unique:users,username',
            'email'               => 'required|string|email|max:255|unique:users,email',
            'phone'               => 'required|string|max:30',
            'register_package'    => 'required|numeric',
            'password'            => 'required|string|min:8|confirmed',
            'post_code'           => 'nullable|string|max:15',
            'gender'              => 'nullable|string|max:7',
            'd_o_b'               => 'nullable|date',
            'nid'                 => 'nullable|string|max:25',
            'nominee'             => 'nullable|string|max:25',
            'nominee_relation'    => 'nullable|string|max:25',
            'profession'          => 'nullable|string|max:255',
            'education'           => 'nullable|string|max:25',
            'facebook'            => 'nullable|string|max:255',
            'present_address'     => 'nullable|string|max:255',
            'permanent_address'   => 'nullable|string|max:255',
            'bank_account_name'   => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:50',
            'branch_name'         => 'nullable|string|max:50',
            'bkash'               => 'nullable|digits:11',
            'nagad'               => 'nullable|digits:11',
            'rocket'              => 'nullable|digits:11'
        ]);

        // Check Sponsor ID
        $sponsor = User::where('referer_id', auth()->user()->referer_id)->first();

        if ($sponsor->shopBalance->amount >= $request->register_package) {

            if ($request->placement_id != null) {
                $placement = User::where('referer_id', $request->placement_id)->first();

                if ($placement) {
                    $activeUser = $placement;

                    for ($i = 0; $i < 11 && $activeUser; $i++)
                    {
                        if ($sponsor->id == $activeUser->sponsor_id) {
                            $child = $placement;
                            $placement_id = $placement->id;
                            while(true){
                                $child = $child->children()->where(['direction' => $request->direction])->first();
                                
                                if ($child) {
                                    $placement_id = $child->id;
                                } else { 
                                    break;
                                }
                            }
                        } else {
                            $activeUser = $activeUser->sponsor; 
                        }
                    }
                    if (!isset($placement_id)) {
                        return response()->json([
                            'alert' => 'Error',
                            'message' => 'Placement id does not match'
                        ]);
                    }
                }
                else {
                    return response()->json([
                        'alert' => 'Error',
                        'message' => 'Placement id does not match'
                    ]);
                }
                
            } 
            else {
                $child = $sponsor;
                $placement_id = $sponsor->id;
                while(true){
                    $child = $child->children()->where(['direction' => $request->direction])->first();
                    if ($child) {
                        $placement_id = $child->id;

                    }  else { 
                        break;
                    }
                }
            }

            // Insert data to users table
            $user = User::create([
                'placement_id'     => $placement_id,
                'sponsor_id'       => $sponsor->id,
                'direction'        => $request->direction,
                'level'            => 'No Level',
                'next_level_bonus' => date('Y-m-d'),
                'name'             => $request->name,
                'referer_id'       => rand(pow(10, 5-1), pow(10, 5)-1),
                'username'         => $request->username,
                'email'            => $request->email,
                'phone'            => $request->phone,
                'register_package' => $request->register_package,
                'password'         => Hash::make($request->password),
                'joining_date'     => date('Y-m-d'),
                'joining_month'    => date('F'),
                'joining_year'     => date('Y')
            ]);
            
            // Insert Data user_infos Table
            $user->userInfo()->updateOrCreate([
                "country"             => $request->country,
                "present_address"     => $request->present_address,
                "permanent_address"   => $request->permanent_address,
                "post_code"           => $request->post_code,
                "d_o_b"               => $request->d_o_b,
                "gender"              => $request->gender,
                "nid"                 => $request->nid,
                "nominee"             => $request->nominee,
                "nominee_relation"    => $request->nominee_relation,
                "profession"          => $request->profession,
                "education"           => $request->education,
                "facebook"            => $request->facebook,
                "bank_name"           => $request->bank_name,
                "bank_account_name"   => $request->bank_account_name,
                "bank_account_number" => $request->bank_account_number,
                "branch_name"         => $request->branch_name,
                "bkash"               => $request->bkash,
                "nagad"               => $request->nagad,
                "rocket"              => $request->rocket
            ]);
            
            // Insert data income_balances table
            $user->incomeBalance()->updateOrCreate([
                'amount'  => 0
            ]);
            // Insert data shop_balances table
            $user->shopBalance()->updateOrCreate([
                'amount'  => 0
            ]);

            // Minus Auth user shop balance
            $sponsor->shopBalance->update([
                'amount' => $sponsor->shopBalance->amount - $request->register_package
            ]);

            // Send Generation and sponsor income
            $activeUser = User::find($user->id);
            $sponsor = $activeUser->sponsor;

            for ($i = 0; $i < 11 && $sponsor; $i++)
            {
                // update user level
                $left   = $sponsor->countLeft();
                $middle = $sponsor->countMiddle();
                $right  = $sponsor->countRight();
                
                if ($left < 2 || $middle < 2 || $right < 2) {
                    $level = 'No Level';
                }
                if ($left >= 2 && $middle >= 2 && $right >= 2) {
                    $level = 'Elite';
                }
                if ($left > 2 && $left >= 9 && $middle > 2 && $middle >= 9 && $right > 2 && $right >= 9) {
                    $level = 'Executive Elite';
                }
                if ($left > 9 && $left >= 50 && $middle >9 && $middle >= 50 && $right > 9 && $right >= 50) {
                    $level = 'Executive';
                }
                if ($left > 50 && $left >= 120 && $middle > 50 && $middle >= 120 && $right > 50 && $right >= 120) {
                    $level = 'Senior Executive';
                }
                if ($left > 120 && $left >= 360 && $middle > 120 && $middle >= 360 && $right > 120 && $right >= 360) {
                    $level = 'Assistant Manager';
                }
                if ($left > 360 && $left >= 1080 && $middle > 360 && $middle >= 1080 && $right > 360 && $right >= 1080) {
                    $level = 'Manager';
                }
                if ($left > 1080 && $left >= 3240 && $middle > 1080 && $middle >= 3240 && $right > 1080 && $right >= 3240) {
                    $level = 'General Manager';
                }
                if ($left > 3240 && $left >= 9270 && $middle > 3240 && $middle >= 9270 && $right > 3240 && $right >= 9270) {
                    $level = 'National Manager';
                }
                if ($left > 9270 && $left >= 29160 && $middle > 9270 && $middle >= 29160 && $right > 9270 && $right >= 29160) {
                    $level = 'Director';
                }
                if ($left > 29160 && $left >= 87480 && $middle > 29160 && $middle >= 87480 && $right > 29160 && $right >= 87480) {
                    $level = 'Presidential Director';
                }
                if ($left >= 87480 && $middle >= 87480 && $right >= 87480) {
                    $level = 'Owners Club Member';
                }
                
                $sponsor->left   = $left;
                $sponsor->middle = $middle;
                $sponsor->right  = $right;
                if ($sponsor->level != $level) {
                    $date = Carbon::create($sponsor->next_level_bonus);
                    $next_level_bonus = $date->addDays(30);
                    $sponsor->level = $level;
                    $sponsor->level_up_date    = date('Y-m-d');
                    $sponsor->next_level_bonus = date('Y-m-d', strtotime($next_level_bonus));
                }
                $sponsor->save();

                // Check current referer user
                if ($i == 0) {
                    $amount = setting('generation_one_income');
                    
                    // Insert data to sponsor_incomes table
                    SponsorIncome::create([
                        'user_id' => $sponsor->id,
                        'amount'  => $amount,
                        'date'    => date('Y-m-d'),
                        'month'   => date('F'),
                        'year'    => date('Y')
                    ]);

                } 
                else {
                    $amount = setting('generation_one_plus_income');
                    
                    // Insert data to generation_incomes table
                    GenerationIncome::create([
                        'user_id' => $sponsor->id,
                        'amount'  => $amount,
                        'date'    => date('Y-m-d'),
                        'month'   => date('F'),
                        'year'    => date('Y')
                    ]);
                }

                // Update income_balances table data
                $sponsor->incomeBalance()->update([
                    'amount' => $sponsor->incomeBalance->amount + $amount
                ]);

                $sponsor = $sponsor->sponsor;
            }

            // Approved Add User
            $user->update([
                'is_approved' => true
            ]);

            return response()->json([
                'alert'   => 'Success',
                'message' => 'Referrer successfully added'
            ]);

        } else {
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'Sorry!! Not enough balance your in your account to register a user'
            ]);
        }
    }
}
