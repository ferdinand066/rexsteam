<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Game extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function transaction_detail(){
        return $this->hasMany(TransactionDetail::class);
    }
}
