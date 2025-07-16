<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products_Languages extends Model
{
    protected $fillable = ['name','description','language_id' , 'product_id'];
    protected $table = 'products_in_different_languages';

    public function products(){
        return $this->belongsTo(Product::class );
    }
    public function languages(){
        return $this->belongsTo(Language::class,'language_id');
    }
}
