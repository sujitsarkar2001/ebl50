<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'username' => $request->username]
        );
    }

    public function reset(Request $request)
    {
        $this->validate($request, [
            '_token'   => 'required',
            'username' => 'required|string',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::where('username', $request->username)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Your password reset successfully, please login'
        ]);
    }

}
