<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingQuestion extends Model
{

    protected $fillable = ['details' , 'question_type']; 
    public function rating(){
        return $this->hasMany(RatingQuestionUserProduct::class , 'rating_questions_id');
    }
}
