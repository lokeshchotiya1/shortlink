<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class UserEmotions extends Model
{
	//protected $connection = 'mysql2';

	protected $table="users_emotions";

    protected $fillable = [
        'user_id','emotion',
    ];


    protected $hidden = [
        'created_at', 'updated_at',
    ];
   
}
