<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $dates=["created_at"];

    protected $fillable = ["offer_name","status","category","url","image_path","products_available","market_price","today_price","stars","users_number","currency","source","group_id"];

    public function user(){
    	return $this->belongsTo(\App\User::class);
    }
}
