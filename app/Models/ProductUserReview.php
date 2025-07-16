<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUserReview extends Model
{
    protected $table = 'table_products_users_review';
    protected $fillable = ['user_id' , 'product_id' , 'bros' , 'cons'];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsTo(Product::class);
    }
}
