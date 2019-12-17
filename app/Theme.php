<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = ["name","geo","status","theme_preview"];

    protected $dates = ["created_at"];
}
