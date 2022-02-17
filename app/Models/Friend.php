<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $incrementing = false;

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    public function friend($userId){
        if ($this->sender_id == $userId){
            return $this->receiver()->first();
        }
        return $this->sender()->first();
    }
}
