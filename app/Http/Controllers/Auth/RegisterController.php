<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IncomeBalance;
use App\Models\ShopBalance;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
     * user register
     *
     * @param  mixed $request
     * @return void
     */

    public function register(Request $request)
    {
        $this->validate($request, [
            'sponsor_id'       => 'required|numeric',
            'placement_id'     => 'nullable|numeric',
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
                            'alert'   => 'Error',
                            'message' => 'Placement id does not match'
                        ]);
                    }
                }
                else {
                    return response()->json([
                        'alert'   => 'Error',
                        'message' => 'Placement id not found'
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
            // return 'STOP';
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
            IncomeBalance::create([
                'user_id' => $user->id
            ]);

            // Create Shop balance account in user
            ShopBalance::create([
                'user_id' => $user->id
            ]);
            return response()->json([
                'alert'   => 'Success',
                'message' => 'Your registration successfully done, please wait to check admin your account.'
            ]);
        }
        else {
            return response()->json([
                'alert'   => 'Error',
                'message' => 'Sponsor id not available, please try to correct reference number'
            ]);
        }
    }
}
