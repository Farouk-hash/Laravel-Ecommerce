<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['sender_id' , 'receiver_id' , 'message'];
    protected $table = 'chat';
}
