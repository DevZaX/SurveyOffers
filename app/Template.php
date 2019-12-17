<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [ "name","geo","isActive","group_id","theme_id" ];

    protected $dates = [ "created_at" ];

    public function offers()
    {
    	return $this->belongsToMany(Offer::class);
    }

    public function group()
    {
    	return $this->belongsTo(Group::class);
    }

    public function domainName()
    {
        $domain = Domain::where("group_id",$this->group_id)->where("isActive",1)->first();
        if(!$domain)
        {
            $domain = Domain::where("isActive",1)->get()->random();
            return $domain->name;
        }
        return $domain->name;
    }
}
