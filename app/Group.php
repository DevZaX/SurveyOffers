<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [ "name" ];

    protected $dates = [ "created_at" ];
}
