<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        } else {
            $this->redirectTo = route('dashboard');
        }
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'sponsor_id' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'country_code' => ['required', 'string', 'max:5'],
            'phone' => ['required', 'digits:10'],
            'side' => ['required', 'string', 'max:20'],
            'register_package' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $check = User::where('sponsor_id', $data['sponsor_id'])->first();
        
        if ($check) {
            return User::create([
                'parent_id'        => $check->id,
                'sponsor_id'       => $data['sponsor_id'],
                'name'             => $data['name'],
                'username'         => $data['username'],
                'email'            => $data['email'],
                'country_code'     => $data['country_code'],
                'phone'            => $data['phone'],
                'side'             => $data['side'],
                'register_package' => $data['register_package'],
                'password'         => Hash::make($data['password']),
            ]);
        }
    }


    public function register(Request $request)
    {
        $this->validate($request, [
            'sponsor_id'       => 'required|numeric',
            'name'             => 'required|string|max:50',
            'username'         => 'required|string|max:50|unique:users,username',
            'email'            => 'required|string|email|max:255',
            'country'          => 'nullable|string|max:50',
            'phone'            => 'required|string|max:30',
            'direction'        => 'required|numeric',
            'register_package' => 'required|numeric',
            'password'         => 'required|string|min:8|confirmed'
        ]);

        $sponsor = User::where('referer_id', $request->sponsor_id)->first();
        
        if ($sponsor) {

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

            $user = User::create([
                'placement_id'     => $placement_id,
                'sponsor_id'       => $sponsor->id,
                'direction'        => $request->direction,
                'name'             => $request->name,
                'referer_id'       => rand(pow(10, 5-1), pow(10, 5)-1),
                'username'         => $request->username,
                'email'            => $request->email,
                'country'          => $request->country,
                'phone'            => $request->phone,
                'register_package' => $request->register_package,
                'password'         => Hash::make($request->password),
                'joining_date'     => date('Y-m-d'),
                'joining_month'    => date('F'),
                'joining_year'     => date('Y')
            ]);

            $user->userInfo()->create([
                "country"         => $request->country,
                "present_address" => $request->address
            ]);

            // Create Income balance account in user
            \App\Models\IncomeBalance::create([
                'user_id' => $user->id
            ]);

            // Create Shop balance account in user
            \App\Models\ShopBalance::create([
                'user_id' => $user->id
            ]);

            return back()->with('success', 'Your registration successfully done, please wait to check admin your account.');
        } else {
            
            return back()->with('wrong', 'Sponsor id not available, please try to correct reference number');
            
        }
        return back();
    }
}
