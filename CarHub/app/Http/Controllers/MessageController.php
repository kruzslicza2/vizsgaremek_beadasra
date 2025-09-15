<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
{
    $userId = Auth::id();

    // Beérkező üzenetek
    $received = Message::where('receiver_id', $userId)
        ->with(['sender', 'car', 'originalMessage'])
        ->latest()
        ->get();

    // Az összes új üzenetet olvasottá tesszük
    Message::where('receiver_id', $userId)
        ->where('read', 0) // vagy ->whereNull('read_at') ha timestamp
        ->update(['read' => 1]); // vagy 'read_at' => now()

    // Elküldött üzenetek
    $sent = Message::where('sender_id', $userId)
        ->with(['receiver', 'car', 'originalMessage'])
        ->latest()
        ->get();

    return view('messages.index', [
        'received' => $received,
        'sent' => $sent
    ]);
}

    public function store(Request $request, Car $car)
    {
        $request->validate([
            'message' => 'required|min:10'
        ]);

        // Ha ez egy válaszüzenet
        if ($request->has('reply_to')) {
            $originalMessage = Message::findOrFail($request->reply_to);

            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $originalMessage->sender_id, // A válasz az eredeti üzenet küldőjének megy
                'car_id' => $car->id,
                'message' => $request->message,
                'reply_to' => $request->reply_to
            ]);
        }
        // Ha ez egy új üzenet
        else {
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $car->user_id,
                'car_id' => $car->id,
                'message' => $request->message
            ]);
        }

        return back()->with('success', 'Üzenet elküldve!');
    }
}
