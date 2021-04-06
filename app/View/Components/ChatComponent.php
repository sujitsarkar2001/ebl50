<?php

namespace App\View\Components;

use App\Models\Chat;
use Illuminate\View\Component;

class ChatComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if (auth()->user()->is_admin) {
            $chats = Chat::where('outgoing_status', false)->get()->unique('user_id');
            
        } else {
            $chats = Chat::where('user_id', auth()->id())->where('incoming_status', false)->get()->unique('user_id');
        }
        
        return view('components.chat-component', compact('chats'));
    }
}
