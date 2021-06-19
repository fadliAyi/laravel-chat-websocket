<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class RoomMessage extends Model
{
    use HasFactory;
    protected $collection = 'room_messages';
    protected $fillable = ['user_room', 'created_at', 'updated_at'];
    public $timestamps = true;
    public function userRoom()
    {
        return $this->hasMany(User::class, 'user_room');
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }
}
