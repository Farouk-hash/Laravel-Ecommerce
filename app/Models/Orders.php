<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    
    protected $table = 'orders';
    protected $fillable = ['billing_addresses_id', 'carts_id', 'status'];
    
    public function billing_addresses(){
        return $this->belongsTo(BillingAdresses::class);
    }
    
    public function carts(){
        return $this->belongsTo(Cart::class);
    }
}
