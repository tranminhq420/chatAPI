<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
}