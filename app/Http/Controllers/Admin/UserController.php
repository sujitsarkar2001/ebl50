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
            'sponsor_id'          => 'required|numeric',
            'direction'           => 'required|numeric',
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
        $sponsor = User::where('referer_id', $request->sponsor_id)->first();
        
        if ($sponsor) {
            
            $child        = $sponsor;
            $placement_id = $sponsor->id;

            while(true){
                $child = $child->children()->where(['direction' => $request->direction])->first();
                if ($child) {
                    $placement_id = $child->id;
                }  else { 
                    break;
                }
                
            }
            
            // Insert data to users table
            $user = User::create([
                'placement_id'     => $placement_id,
                'sponsor_id'       => $sponsor->id,
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
        } else {

            notify()->warning("Sponsor id not available, please try to correct sponsor id", "Sorry!!");
            
            return back();
        }
        
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

            } else {
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
