<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingAdresses extends Model
{
    protected $table = 'billing_addresses';
    protected $fillable = ['user_id', 'name', 'email', 'address', 'phone', 'something' , 'total'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orders(){
        return $this->hasMany(Orders::class , 'billing_addresses_id');
    }
}
