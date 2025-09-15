<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'car_id', 'message', 'read', 'reply_to'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function originalMessage()
    {
        return $this->belongsTo(Message::class, 'reply_to');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'reply_to');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

