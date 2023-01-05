<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['username', 'password'];
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_user', 'user_id', 'room_id');
    }


    // protected $appends = ['rooms', 'owned_rooms'];
    protected $hidden = ['created_at', 'password', 'updated_at', 'rmb_token'];
}