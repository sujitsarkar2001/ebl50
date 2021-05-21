<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_admin', false)->latest('id')->get();
        
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
                        notify()->warning("Direction is not accept to null value", "Wrong");
                        return back();
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
                            notify()->warning("Placement id does not match", "Wrong");
                            return back();
                        }
                    }
                    else {
                        notify()->warning("Placement id not found", "Wrong");
                        return back();
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
                notify()->warning("Sponsor id not available, please try to correct sponsor id", "Wrong");
                return back(); 
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
            'direction'        => $request->direction,
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

        notify()->success("User successfully added", "Success");
        return redirect()->route('admin.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'                => 'required|string|max:50',
            'username'            => 'required|string|max:50|unique:users,username,'.$user->id,
            'email'               => 'required|string|email|max:255',
            'phone'               => 'required|string|max:30',
            'register_package'    => 'required|numeric',
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
        
        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone
        ]);
        
        $user->userInfo->update([
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
        
        notify()->success("User successfully updated", "Success");
    
        return redirect()->route('admin.user.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (file_exists('uploads/member/'.$user->avatar)) {
            unlink('uploads/member/'.$user->avatar);
        }
        $user->delete();
        notify()->success("User successfully deleted", "Success");
        return back();
    }
    
    
    /**
     * Show New Users.
     */

    public function showNewUser()
    {
        $users = User::where('is_admin', false)->where('is_approved', false)->latest('id')->get();
        
        return view('admin.user.new', compact('users'));
    }
    
    /**
     * Show Blocked Users.
     */

    public function showBlockedUser()
    {
        $users = User::where('is_admin', false)->where('status', false)->latest('id')->get();
        
        return view('admin.user.blocked', compact('users'));
    }
    
    /**
     * Approved User.
     */

    public function approved($id)
    {
        $activeUser = User::findOrFail($id);
        
        $sponsor = $activeUser->sponsor;

        for ($i = 0; $i < 11 && $sponsor; $i++)
        {
            // Check current referer user
            if ($i == 0) {
                $amount = setting('generation_one_income');
                
                // Insert data to sponsor_incomes table
                $sponsor->sponsorIncomes()->create([
                    'amount'  => $amount,
                    'status'  => true,
                    'date'    => date('Y-m-d'),
                    'month'   => date('F'),
                    'year'    => date('Y')
                ]);

            } 
            else {
                $amount = setting('generation_one_plus_income');
                
                // Insert data to generation_incomes table
                $sponsor->generationIncomes()->create([
                    'amount'  => $amount,
                    'status'  => true,
                    'date'    => date('Y-m-d'),
                    'month'   => date('F'),
                    'year'    => date('Y')
                ]);
            }

            // update user level
            $left   = $sponsor->countLeft();
            $middle = $sponsor->countMiddle();
            $right  = $sponsor->countRight();
            
            if ($left < 2 || $middle < 2 || $right < 2) {
                $sponsor->update([ 'level' => 'No Level' ]);
            }
            if ($left >= 2 && $middle >= 2 && $right >= 2) {
                $sponsor->update([ 'level' => 'Elite' ]);
            }
            if ($left > 2 && $left >= 9 && $middle > 2 && $middle >= 9 && $right > 2 && $right >= 9) {
                $sponsor->update([ 'level' => 'Executive Elite' ]);
            }
            if ($left > 9 && $left >= 50 && $middle >9 && $middle >= 50 && $right > 9 && $right >= 50) {
                $sponsor->update([ 'level' => 'Executive' ]);
            }
            if ($left > 50 && $left >= 120 && $middle > 50 && $middle >= 120 && $right > 50 && $right >= 120) {
                $sponsor->update([ 'level' => 'Senior Executive' ]);
            }
            if ($left > 120 && $left >= 360 && $middle > 120 && $middle >= 360 && $right > 120 && $right >= 360) {
                $sponsor->update([ 'level' => 'Assistant Manager' ]);
            }
            if ($left > 360 && $left >= 1080 && $middle > 360 && $middle >= 1080 && $right > 360 && $right >= 1080) {
                $sponsor->update([ 'level' => 'Manager' ]);
            }
            if ($left > 1080 && $left >= 3240 && $middle > 1080 && $middle >= 3240 && $right > 1080 && $right >= 3240) {
                $sponsor->update([ 'level' => 'General Manager' ]);
            }
            if ($left > 3240 && $left >= 9270 && $middle > 3240 && $middle >= 9270 && $right > 3240 && $right >= 9270) {
                $sponsor->update([ 'level' => 'National Manager' ]);
            }
            if ($left > 9270 && $left >= 29160 && $middle > 9270 && $middle >= 29160 && $right > 9270 && $right >= 29160) {
                $sponsor->update([ 'level' => 'Director' ]);
            }
            if ($left > 29160 && $left >= 87480 && $middle > 29160 && $middle >= 87480 && $right > 29160 && $right >= 87480) {
                $sponsor->update([ 'level' => 'Presidential Director' ]);
            }
            if ($left >= 87480 && $middle >= 87480 && $right >= 87480) {
                $sponsor->update([ 'level' => 'Owners Club Member' ]);
            }
            
            // Update income_balances table data
            $sponsor->incomeBalance()->update([
                'amount' => $sponsor->incomeBalance->amount + $amount
            ]);

            $sponsor = $sponsor->sponsor;
        }

        $activeUser->update([
            'is_approved' => true
        ]);

        notify()->success("User successfully approved & send sponsor bonus user account", "Success");
        return back();
    }
    
    /**
     * Update User Status.
     */

    public function status($id)
    {
        $user = User::findOrFail($id);
        if ($user->status == true) {
            
            $user->update([
                'status' => false
            ]);
        } else {
            $user->update([
                'status' => true
            ]);
        }
        notify()->success("User status successfully updated", "Success");
        return back();
    }

}
