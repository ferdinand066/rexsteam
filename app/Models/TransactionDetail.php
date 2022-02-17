<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function header(){
        return $this->belongsTo(TransactionHeader::class);
    }
}
