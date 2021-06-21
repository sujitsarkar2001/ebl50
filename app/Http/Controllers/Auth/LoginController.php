<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo; // = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::check() && Auth::user()->is_admin == true) {

            $this->redirectTo = route('admin.dashboard');

        } else if (Auth::check() && Auth::user()->is_admin == false) {
            $this->redirectTo = route('dashboard');
        }
        $this->middleware('guest')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = array(
            'username' => $request->username,
            'password' => $request->password
        );
        $remember_me  = ( !empty( $request->remember ) )? TRUE : FALSE;
        // $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if(auth()->attempt($credentials))
        {
            $user = User::where(["username" => $credentials['username']])->first();

            Auth::login($user, $remember_me);

            // return redirect()->intended($this->redirectPath());
            // return $this->redirectPath();

            if ($user->is_admin) {
                $redirect = '/admin';
            } else {
                $redirect = '/';
            }
            
            
            return response()->json([
                'alert'    => 'Success',
                'redirect' => $redirect,
                'message'  => 'You are successfully logged in, please wait',
            ]);

        }else{
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'Username and password not match'
            ]);
            // notify()->error("Username and password not match", "Not Match");
            // return back();
        }

    }
}
