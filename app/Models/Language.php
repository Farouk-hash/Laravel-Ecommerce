<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name','symbol'];
    protected $table = 'languages';

    public function products(){
        return $this->hasMany(Products_Languages::class , 'language_id');
    }
    public function categories(){
        return $this->hasMany(Categories_Languages::class , 'language_id');
    }
}
