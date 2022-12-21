<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class User extends Model
{
    use HasFactory;



    public function getOwnedRoomsAttribute($value)
    {
        return $this->owners();
    }

    public function getRoomsAttribute($value)
    {
        return $this->rooms();
    }



    // public function owners()
    // {
    //     return $this->hasMany(Room::class, 'admin_id', 'id');
    // }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function rooms()
    {
        return $this->belongsToMany('App\Models\Room');
    }



    // protected $appends = ['rooms', 'owned_rooms'];
    protected $hidden = ['created_at', 'password', 'updated_at', 'token'];
}