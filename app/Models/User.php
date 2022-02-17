<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;

    protected $guarded = [];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sender(){
        return $this->hasMany(User::class, 'sender_id', 'id');
    }

    public function receiver(){
        return $this->hasMany(User::class, 'receiver_id', 'id');
    }

    public function transactions(){
        return $this->hasMany(TransactionHeader::class);
    }

    public function getLevelAttribute(){
        $total = 0;
        foreach($this->transactions as $header){
            $total += count($header->details);
        }
        return $total;
    }
}
