<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $actingAsUser = User::find($request->user_id);

        $actingAsUser->message()->create([
            'message' => $request->message,
            'room_id' => $request->room_id
        ]);

        //broadcast message to other

        return response()->json([
            'status' => true,
            'message' => ''
        ]);
    }

    public function list($roomId)
    {
        $message = Message::where('room_id', $roomId)->get();
        return response()->json($message);
    }
}
