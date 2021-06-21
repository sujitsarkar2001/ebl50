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
            'password'         => 'required|min:8|confirmed'
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
                return response()->json([
                    'alert'   => 'Success',
                    'message' => 'Password Change Successfully'
                ]);
                
            } else {
                return response()->json([
                    'alert'   => 'Warning',
                    'message' => 'New password can not be same as current password!'
                ]);
            }

        } else {
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'Password does not match!!'
            ]);
        }
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
        
        $user = User::find(Auth::user()->id);
        
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

        }

        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'avatar'   => $imageName ?? $user->avatar
        ]);
        
        return response()->json([
            'alert'   => 'Success',
            'message' => 'Your profile info successfully updated'
        ]);
        
    }
    
    /**
     * getInfo
     *
     * @return void
     */
    public function getInfo() 
    {
        $admin = User::find(auth()->id(), ['name', 'username', 'phone', 'email', 'status', 'avatar']);
        return response()->json($admin);
    }
}
