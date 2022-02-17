<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $guarded = [];

    public function details(){
        return $this->hasMany(TransactionDetail::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getTotalPriceAttribute(){
        $total = 0;
        foreach($this->details as $detail){
            $total += $detail->price;
        }
        return $total;
    }
}
