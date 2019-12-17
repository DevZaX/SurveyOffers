<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $dates = [ 'created_at' ];

    protected $fillable = [ "name","status" ];
}
