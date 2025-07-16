<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingQuestionUserProduct extends Model
{
    protected $table = 'rating_questions_users_products';
    protected $fillable = ['rating_questions_id' , 'user_id' , 'product_id' , 'rating_value'];
    
    public function question(){
        return $this->belongsTo(RatingQuestion::class , 'rating_questions_id');
    }

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsTo(Product::class);
    }
}
