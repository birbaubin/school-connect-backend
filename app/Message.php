<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
   
    protected $fillable = [
        'text', 'object', 'recipientId', 'senderId', 'password', 'state'
    ];


    protected $table = 'messages';
}
