<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;



    // public function getOwnedRoomsAttribute($value)
    // {
    //     return $this->owners();
    // }

    // public function getRoomsAttribute($value)
    // {
    //     return $this->rooms();
    // }



    // public function owners()
    // {
    //     return $this->hasMany(Room::class, 'admin_id', 'id');
    // }
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