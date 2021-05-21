<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\Notice;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ExtraController extends Controller
{
    public function viewPage($slug)
    {
        $page = Page::where('slug', $slug)->where('status', true)->firstOrFail();
        return view('user.page', compact('page'));
    }

    public function showReferrerForm()
    {
        return view('user.add-referrer');
    }

    public function storeReferrer(Request $request)
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

            // Minus Auth user shop balance
            $sponsor->shopBalance->update([
                'amount' => $sponsor->shopBalance->amount - $request->register_package
            ]);

            // Send Generation and sponsor income
            $activeUser = User::findOrFail($user->id);
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
            // Approved Add User
            $activeUser->update([
                'is_approved' => true
            ]);

            notify()->success("Referrer successfully added", "Success");
            return back();
        } 
        else {
            notify()->warning("Sorry!! Not enough balance your in your account to register a user", "Warning");
            return back();
        }
        
    }

    // Show Contact Form
    public function showContactForm()
    {
        return view('user.connection.contact');
    }

    public function storeContact(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email|string|max:50',
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);
        
        $user = auth()->user();

        Contact::create([
            'user_id' => $user->id,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        $data = [
            'name'     => $user->name, 
            'username' => $user->username, 
            'email'    => $request->input('email'), 
            'subject'  => $request->input('subject'),
            'body'     => $request->input('message')
        ];

        Mail::send('contact-email', $data, function($mail) use ($data)
        {
            $mail->from($data['email'], $data['name'])
                ->to(config('mail.from.address'),'Sujit Sarkar')
                ->subject($data['subject']);
            
        });

        return response()->json([
            'alert' => 'success'
        ]);

    }

    // Show Live Chat Form
    public function showLiveChatForm()
    {
        return view('user.connection.chat');
    }

    public function liveChatList()
    {
        $chats = Chat::where('user_id', auth()->id())->with('user')->get();
        
        foreach ($chats as $chat) {
            
            $chat->update([
                'user_status' => true
            ]);
        }

        return response()->json($chats);
    }

    // Show Live Chat Form
    public function storeLiveChatForm(Request $request)
    {
        $this->validate($request, [
            'message' => 'required|string'
        ]);
        
        Chat::create([
            'user_id'           => auth()->id(),
            'message'           => $request->message,
            'user_status'       => true,
            'admin_message_log' => 'incoming',
            'user_message_log'  => 'outgoing'
        ]);

        return response()->json([
            'alert' => 'success'
        ]);
        
    }

    // Count New Message
    public function countNewMessage()
    {
        $count = auth()->user()->chats->where('user_message_log', 'incoming')->where('user_status', false)->count();
        return response()->json($count);
    }

    // Show Notice
    public function showNotice($slug)
    {
        $notice = Notice::where('slug', $slug)->firstOrFail();
        return view('user.notice', compact('notice'));
    }


    // show level
    public function showLevel()
    {
        $elite        = User::where('is_admin', false)->where('level', 'Elite')->count();
        $ex_elite     = User::where('is_admin', false)->where('level', 'Executive Elite')->count();
        $executive    = User::where('is_admin', false)->where('level', 'Executive')->count();
        $si_ex        = User::where('is_admin', false)->where('level', 'Senior Executive')->count();
        $as_mng       = User::where('is_admin', false)->where('level', 'Assistant Manager')->count();
        $manager      = User::where('is_admin', false)->where('level', 'Manager')->count();
        $gn_manager   = User::where('is_admin', false)->where('level', 'General Manager')->count();
        $na_manager   = User::where('is_admin', false)->where('level', 'National Manager')->count();
        $director     = User::where('is_admin', false)->where('level', 'Director')->count();
        $pro_director = User::where('is_admin', false)->where('level', 'Presidential Director')->count();
        $o_c_member   = User::where('is_admin', false)->where('level', 'Owners Club Member')->count();
        $levels = array(
            array('slug' => 'elite','name' => 'Elite', 'members' => $elite),
            array('slug' => 'executive-elite','name' => 'Executive Elite', 'members' => $ex_elite),
            array('slug' => 'executive','name' => 'Executive', 'members' => $executive),
            array('slug' => 'senior-executive','name' => 'Senior Executive', 'members' => $si_ex),
            array('slug' => 'assistant-manager','name' => 'Assistant Manager', 'members' => $as_mng),
            array('slug' => 'manager','name' => 'Manager', 'members' => $manager),
            array('slug' => 'general-manager','name' => 'General Manager', 'members' => $gn_manager),
            array('slug' => 'national-manager','name' => 'National Manager', 'members' => $na_manager),
            array('slug' => 'director','name' => 'Director', 'members' => $director),
            array('slug' => 'presidential-director','name' => 'Presidential Director', 'members' => $pro_director),
            array('slug' => 'owners-club-member','name' => 'Owners Club Member', 'members' => $o_c_member)
        );
        
        return view('user.level.index', compact('levels'));
    }

    // show level user
    public function showLevelUser($slug)
    {
        $name = str_replace('-', ' ', $slug);

        $users = User::where('is_admin', false)->where('status', true)->where('level', ucwords($name))->where('is_approved', true)->get(['name', 'username', 'avatar', 'joining_date']);
        
        return view('user.level.list', compact('users', 'name'));
    }
}
