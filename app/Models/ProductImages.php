<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $fillable = ['image_path' , 'product_id','file_object_key'];

    public function products(){
        return $this->belongsTo(Product::class , 'product_id');
    }
}
