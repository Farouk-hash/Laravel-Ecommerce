<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory ; 
    protected $fillable = ['name','price','description','quantity','category_id' , 'image_path','file_object_key'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function images(){
        return $this->hasMany(ProductImages::class , 'product_id');
    }

    public function reviews_txt(){
        return $this->hasMany(ProductUserReview::class , 'product_id');
    }

    public function reviews_rating(){
        return $this->hasMany(RatingQuestionUserProduct::class , 'product_id');
    }

    public function product_languages(){
        return $this->hasMany(Products_Languages::class , 'product_id');
    }
}
