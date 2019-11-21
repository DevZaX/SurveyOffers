<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMarketPriceAndTodayPriceOffers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("offers",function(Blueprint $table){
            $table->string("market_price")->change();
            $table->string("today_price")->change();
        });
    }
}
