<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories_Languages extends Model
{
    protected $fillable = ['name','description','language_id' , 'categories_id'];
    protected $table = 'categories_in_different_languages';

    public function categories(){
        return $this->belongsTo(Category::class , 'id' );
    }
    public function languages(){
        return $this->belongsTo(Language::class , 'language_id');
    }
}
