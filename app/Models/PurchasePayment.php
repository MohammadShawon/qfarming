<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
}