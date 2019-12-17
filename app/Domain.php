<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = [ "name","group_id","isActive" ];

    protected $dates = [ "created_at" ];

    public function group()
    {
    	return $this->belongsTo(Group::class);
    }
}
