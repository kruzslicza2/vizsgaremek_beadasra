<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = ['username','email','password','bio','active'];
    protected $hidden = ['password'];

    public function cars() {
        return $this->hasMany(Car::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function sentMessages() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages() {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    public function unreadMessages()
{
    return $this->hasMany(Message::class, 'receiver_id')->where('read', 0);
}

}
