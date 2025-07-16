<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory ; 
    protected $fillable =  ['name','description','image_path','file_object_key'];
    public function products(){
        return $this->hasMany(Product::class);
    }
    public function languages(){
        return $this->hasMany(Categories_Languages::class , 'categories_id');
    }
}
