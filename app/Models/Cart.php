<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    
    protected $fillable = ['user_id' , 'product_id' , 'price' , 'quantity' , 'total' , 'save_later' , 'finished'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function orders(){
        return $this->hasMany(Orders::class);
    }
}
