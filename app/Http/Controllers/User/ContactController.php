<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

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
            'alert'   => 'Success',
            'message' => 'Receive your contact information successfully'
        ]);
    }

    public function showLiveChatForm()
    {
        $messages = auth()->user()->chats->count();
        return view('user.connection.chat', compact('messages'));
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
}
