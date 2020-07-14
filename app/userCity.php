<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userCity extends Model
{
    protected $table='user_city';

    protected $fillable = [
        'email', 'city', 
    ];

}
