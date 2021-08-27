<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class UserConversations extends Model
{
	//protected $connection = 'mysql2';

	protected $table="users_conversations";

    protected $fillable = [
        'user_id','conversation_id','conversation_submitted_time'
    ];


    protected $hidden = [
        'created_at', 'updated_at',
    ];
   
}
