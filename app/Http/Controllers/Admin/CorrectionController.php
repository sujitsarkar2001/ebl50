<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CorrectionController extends Controller
{
    // Show Contact list
    public function showContactForm()
    {
        $contacts = Contact::latest('id')->get();
        return view('admin.connection.contact', compact('contacts'));
    }

    // Delete Contact
    public function destroyContact($id)
    {
        Contact::findOrFail($id)->delete();
        
        notify()->success("Contact successfully deleted", "Success");
        return back();
    }

    // Delete Contact
    public function showContact($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.connection.show', compact('contact'));
    }

    // Reply Contact Form
    public function showReplyContactForm($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.connection.reply', compact('contact'));
    }

    // Reply Contact
    public function replyContact(Request $request)
    {
        $contact = Contact::findOrFail($request->contact_id);
        
        $this->validate($request, [
            'from'    => 'required|string|email',
            'to'      => 'required|string|email',
            'message' => 'required|string'
        ]);
        $admin = auth()->user();

        $data = [
            'name'       => $admin->name, 
            'from_email' => $request->input('from'), 
            'to_email'   => $request->input('to'), 
            'email'      => $request->input('email'), 
            'subject'    => $contact->subject,
            'body'       => $request->input('message')
        ];
        
        Mail::send('admin.connection.contact-email', $data, function($mail) use ($data)
        {
            $mail->from($data['from_email'], $data['name'])
                ->to($data['to_email'], $data['name'])
                ->subject($data['subject']);
            
        });

        ContactReply::create([
            'contact_id' => $contact->id,
            'message'   => $request->message
        ]);

        $contact->update([
            'status' => true
        ]);
        
        
        notify()->success("Congratulations!! Contact reply successfully done", "Success");
        return redirect(route('admin.connection.contact'));

    }

    // Show Live Chat Form
    public function showLiveChatForm()
    {
        return view('admin.connection.chat');
    }

    // Chat User List
    public function liveChatUserList()
    {
        $chats = Chat::with('user')->latest('id')->get()->unique('user_id');
        
        return response()->json($chats);
    }

    public function liveChatList()
    {
        $chats = Chat::with('user')->get();
        
        return response()->json($chats);
    }

    // Show Live Chat Form
    public function storeLiveChatForm(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'message' => 'required|string'
        ]);
        
        Chat::create([
            'user_id'           => $request->user_id,
            'staff_id'          => auth()->id(),
            'message'           => $request->message,
            'admin_status'      => true,
            'admin_message_log' => 'outgoing',
            'user_message_log'  => 'incoming'
        ]);

        return response()->json([
            'alert' => 'success'
        ]);
        
    }

    public function liveChatListById($id)
    {
        $user = User::findOrFail($id);
        $user->chats;

        foreach ($user->chats as $chat) {
            
            $chat->update([
                'admin_status' => true
            ]);
        }

        return response()->json($user);
    }

    // Update Message Status
    public function updateStatus($id)
    {
        $users = Chat::where('user_id', $id)->get();
        
        foreach ($users as $user) {
            
            $user->update([
                'admin_status' => true
            ]);
        }

        return response()->json('Success');
        
    }

    // Count New Message
    public function countNewMessage()
    {
        $count = Chat::where('admin_status', false)->count();
        return response()->json($count);
    }
}
