<?php 


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\items;
use App\Notifications\NewMessageNotification;



class MessageController extends Controller
{
    public function create($receiverId)
    {
        $receiver = User::findOrFail($receiverId);
        return view('items.message', compact('receiver'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'content' => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id',
        
        ]);

     $message = Message::create([
    'sender_id' => auth()->id(),
    'receiver_id' => $request->receiver_id,
    'content' => $request->content,
]);

$message->receiver->notify(new \App\Notifications\NewMessageNotification($message));

        return redirect()->route('users.show', $request->receiver_id)->with('success', 'Message sent!');
    }


    public function inbox()
{
    $messages = Message::where('receiver_id', auth()->id())
                       ->with('sender')
                       ->latest()
                       ->get();

    return view('items.inbox', compact('messages'));
}

}
