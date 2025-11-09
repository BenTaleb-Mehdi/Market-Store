<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    /**
     * Store a new message from contact form
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000'
        ]);

        $message = Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'user_id' => Auth::id() // Will be null for guests
        ]);

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Show user's inbox (for authenticated users)
     */
    public function inbox()
    {
        // Update last message check timestamp
        Auth::user()->update(['last_message_check' => now()]);
        
        $messages = Message::where('user_id', Auth::id())
            ->orWhere('email', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('messages.inbox', compact('messages'));
    }

    /**
     * Show specific message for user
     */
    public function show(Message $message)
    {
        // Check if user can view this message
        if ($message->user_id !== Auth::id() && $message->email !== Auth::user()->email) {
            abort(403);
        }

        // Update last message check timestamp to clear notifications
        Auth::user()->update(['last_message_check' => now()]);

        // Mark as read if it was unread
        if ($message->status === 'unread') {
            $message->markAsRead();
        }

        return view('messages.show', compact('message'));
    }

    /**
     * Clear message notifications (AJAX endpoint)
     */
    public function clearNotifications()
    {
        Auth::user()->update(['last_message_check' => now()]);
        
        return response()->json(['success' => true]);
    }
}
