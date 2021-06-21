<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GenerationIncome;
use App\Models\IncomeBalance;
use App\Models\LevelIncome;
use App\Models\MoneyExchange;
use App\Models\SendShopBalance;
use App\Models\ShareIncome;
use App\Models\ShopBalance;
use App\Models\SponsorIncome;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::where('is_admin', false)->latest('id')->get();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'sponsor_id'          => 'nullable|numeric',
            'placement_id'        => 'nullable|numeric',
            'direction'           => 'nullable|numeric',
            'name'                => 'required|string|max:50',
            'username'            => 'required|string|max:25|unique:users,username',
            'email'               => 'required|string|email|max:255',
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
        if ($request->sponsor_id != null) {
            $sponsor    = User::where('referer_id', $request->sponsor_id)->first();

            if ($sponsor) {
                $sponsor_id = $sponsor->id;
                if ($request->placement_id != null) {

                    if ($request->direction == null) {
                        return response()->json([
                            'alert'  => 'Wrong',
                            'message' => 'Direction is not accept to null value'
                        ]);
                    }
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
                                'alert'   => 'Wrong',
                                'message' => 'Placement id does not match'
                            ]);
                        }
                    }
                    else {
                        return response()->json([
                            'alert'   => 'Wrong',
                            'message' => 'Placement id does not found'
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
            } else {
                return response()->json([
                    'alert'   => 'Wrong',
                    'message' => 'Sponsor id not available, please try to correct sponsor id'
                ]);
            }
        }
        else {
            $sponsor_id   = $request->sponsor_id;
            $placement_id = $request->placement_id;
        }

        // Insert data to users table
        $user = User::create([
            'sponsor_id'       => $sponsor_id,
            'placement_id'     => $placement_id,
            'direction'        => $request->sponsor_id == null ? 0:$request->direction,
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

        return response()->json([
            'alert'   => 'Success',
            'message' => 'User successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        $user->makeHidden('userInfo', 'referrals');
        $sponsor  = $user->sponsor ? $user->sponsor->only(['name', 'username', 'referer_id']) : '';
        $income_balance           = IncomeBalance::where('user_id', $user->id)->first(['amount']);
        $shop_balance             = ShopBalance::where('user_id', $user->id)->first(['amount']);
        $share_income             = ShareIncome::where('user_id', $user->id)->sum('amount');
        $sponsor_income           = SponsorIncome::where('user_id', $user->id)->sum('amount');
        $generation_income        = GenerationIncome::where('user_id', $user->id)->sum('amount');
        $level_income             = LevelIncome::where('user_id', $user->id)->sum('amount');
        $daily_income             = $user->videos->sum('rate');
        $withdraw_paid            = Withdraw::where('user_id', $user->id)->where('status', true)->sum('amount');
        $withdraw_pending         = Withdraw::where('user_id', $user->id)->where('status', false)->sum('amount');
        $money_exchanges          = MoneyExchange::where('user_id', $user->id)->where('status', true)->sum('amount');
        $parent_send_shop_balance = SendShopBalance::where('parent_id', $user->id)->sum('amount');
        $send_shop_balance        = SendShopBalance::where('user_id', $user->id)->sum('amount');
        
        return response()->json([
            'member'                   => $user,
            'info'                     => $user->userInfo,
            'sponsor'                  => $sponsor,
            'referrals'                => $user->referrals->count(),
            'income_balance'           => $income_balance,
            'shop_balance'             => $shop_balance,
            'share_income'             => $share_income,
            'sponsor_income'           => $sponsor_income,
            'generation_income'        => $generation_income,
            'level_income'             => $level_income,
            'daily_income'             => $daily_income,
            'withdraw_paid'            => $withdraw_paid,
            'withdraw_pending'         => $withdraw_pending,
            'money_exchanges'          => $money_exchanges,
            'parent_send_shop_balance' => $parent_send_shop_balance,
            'send_shop_balance'        => $send_shop_balance
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $user->makeHidden('userInfo');
        return response()->json([
            'member' => $user,
            'info'   => $user->userInfo
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'                => 'required|string|max:50',
            'username'            => 'required|string|max:50|unique:users,username,'.$user->id,
            'email'               => 'required|string|email|max:255',
            'phone'               => 'required|string|max:30',
            'post_code'           => 'nullable|string|max:15',
            'country'             => 'nullable|string',
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

        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone
        ]);
        $userInfo = UserInfo::where('user_id', $user->id)->first();
        $userInfo->update([
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
            "address"             => $request->address,
            "bank_name"           => $request->bank_name,
            "bank_account_name"   => $request->bank_account_name,
            "bank_account_number" => $request->bank_account_number,
            "branch_name"         => $request->branch_name,
            "bkash"               => $request->bkash,
            "nagad"               => $request->nagad,
            "rocket"              => $request->rocket
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Member successfully updated'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        if (file_exists('uploads/member/'.$user->avatar)) {
            unlink('uploads/member/'.$user->avatar);
        }
        $user->delete();
        return response()->json([
            'alert'   => 'Success',
            'message' => 'User successfully deleted'
        ]);
    }


    /**
     * Show New Users.
     */

    public function showNewUser()
    {
        return view('admin.user.new');
    }

    /**
     * Show Blocked Users.
     */

    public function showBlockedUser()
    {
        return view('admin.user.blocked');
    }

    /**
     * Show Approved Users.
     */

    public function showApprovedUser()
    {
        return view('admin.user.approved');
    }

    /**
     * Approved User.
     */

    public function approved($id)
    {
        $user = User::findOrFail($id);

        $sponsor = $user->sponsor;
        
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
                $sponsor->level  = $level;
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

            } else {
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

        $user->update([
            'is_approved' => true
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'User successfully approved & send sponsor bonus user account'
        ]);
    }

    /**
     * Update User Status.
     */

    public function status($id)
    {
        $user   = User::findOrFail($id);
        $status = $user->status ? false : true;
        $user->status = $status;
        $user->save();
        return response()->json([
            'alert'   => 'Success',
            'message' => 'User status successfully updated'
        ]);
        
    }

}
