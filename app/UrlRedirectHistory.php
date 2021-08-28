<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlRedirectHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table="url_redirect_history";

    protected $fillable = [
        'ip_address', 'url_id'
    ];
}