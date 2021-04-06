<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show Authenticated User Profile
    public function index()
    {
        return view('admin.profile.index');
    }

    // Show Authenticated User Profile
    public function showUpdateProfileForm()
    {
        $user = Auth::user();
        return view('admin.profile.update', compact('user'));
    }

    // Show Change Password Form
    public function showChangePasswordForm()
    {
        return view('admin.profile.password-change');
    }

    // Update Password to Authenticated Admin
    public function updatePassword(Request $request) 
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Get logged in user.
        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            
            if (!Hash::check($request->password, $user->password)) {
                
                $authUser = User::find($user->id);
                $authUser->update([
                    'password' => Hash::make($request->password),
                ]);
                
                Auth::logout();
                notify()->success("Success", "Password Change Successfully");
                
                return back();
                
            } else {
                notify()->warning("Sorry!", "New password can't be same as current password! ⚡️");
            }

        } else {
            notify()->error("Wrong!", "Password does not match!!");
        }

        return back();
        
    }

    public function updateInfo(Request $request)
    {
        $this->validate($request, [
            'avatar'    => 'nullable|image|max:1024|mimes:jpeg,jpg,png,bmp',
            'name'      => 'required|string|max:50',
            'username'  => 'required|string|max:50',
            'email'     => 'required|string|email|max:255',
            'phone'     => 'required|string|max:30'
        ]);
        
        $user = User::findOrFail(Auth::user()->id);
        
        $avatar = $request->file('avatar');
        if ($avatar) {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $currentDate.'-'.uniqid().'.'.$avatar->getClientOriginalExtension();
            
            if (file_exists('uploads/member/'.$user->avatar)) {
                unlink('uploads/member/'.$user->avatar);
            }

            if (!file_exists('uploads/member')) {
                mkdir('uploads/member', 0777, true);
            }
            $avatar->move(public_path('uploads/member'), $imageName);

        } else {
            $imageName = $user->avatar;
        }

        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'avatar'   => $imageName
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
        
        notify()->success("Your profile info successfully updated", "Success");
    
        return redirect()->route('admin.profile.index');
        
    }
}