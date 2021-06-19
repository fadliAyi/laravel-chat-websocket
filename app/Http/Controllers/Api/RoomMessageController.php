<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\RoomMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomMessageController extends Controller
{
    public function createOrUpdate($userIdReceiver)
    {
        $actingAsUser = User::find('60cd5cb7ab72a07b62397352');

        $room = RoomMessage::firstOrNew(
            ['user_room' => [$actingAsUser->id, $userIdReceiver]],
            ['user_room' => [$actingAsUser->id, $userIdReceiver]]
        );

        $room = RoomMessage::whereIn('user_room', [$actingAsUser->id, $userIdReceiver]);

        if($room->exists()){
            return response()->json($room->first());
        }

        $room = RoomMessage::create(
            ['user_room' => [$actingAsUser->id, $userIdReceiver]]
        );

        return response()->json($room);
    }

    public function list(Request $request)
    {
        $user_id = '60cd5cb7ab72a07b62397352';
        $room = RoomMessage::where('user_room', $user_id)->get()->map(function($item) use ($user_id){
            $item->userRecaived = collect($item->user_room)->map(function($user) use ($user_id){
                if($user != $user_id){
                    return User::find($user);
                }
            })->filter()->first();
            return $item;
        });
        return response()->json($room);
    }
}
