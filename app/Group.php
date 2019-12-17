<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [ "name" ];

    protected $dates = [ "created_at" ];

    public function offers()
    {
    	return $this->hasMany(Offer::class);
    }

    public function user()
    {
    	return $this->hasOne(User::class);
    }

    public function templates()
    {
        return $this->hasMany(Template::class);
    }
}
