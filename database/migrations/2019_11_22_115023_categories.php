<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Categories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->boolean("status");
            $table->timestamps();
        });

        \DB::table("categories")->insert([
            [ "name"=> "App_Entertainment","status"=>1,"created_at"=>now() ],
            [ "name"=> "Automotive","status"=>1,"created_at"=>now() ],
            [ "name"=> "BeautyHealth","status"=>1,"created_at"=>now() ],
            [ "name"=> "BizOpp","status"=>1,"created_at"=>now() ],
            [ "name"=> "Cash_Payday","status"=>1,"created_at"=>now() ],
            [ "name"=> "Casino","status"=>1,"created_at"=>now() ],
            [ "name"=> "Charity","status"=>1,"created_at"=>now() ],
            [ "name"=> "CPC_Leadgen","status"=>1,"created_at"=>now() ],
            [ "name"=> "Credit","status"=>1,"created_at"=>now() ],
            [ "name"=> "Crypto_Forex","status"=>1,"created_at"=>now() ],
            [ "name"=> "Dating","status"=>1,"created_at"=>now() ],
            [ "name"=> "Deal_Coupons","status"=>1,"created_at"=>now() ],
            [ "name"=> "Debt","status"=>1,"created_at"=>now() ],
            [ "name"=> "Diet","status"=>1,"created_at"=>now() ],
            [ "name"=> "E-commerce","status"=>1,"created_at"=>now() ],
            [ "name"=> "Education","status"=>1,"created_at"=>now() ],
            [ "name"=> "App_Entertainment","status"=>1,"created_at"=>now() ],
            [ "name"=> "Financial","status"=>1,"created_at"=>now() ],
            [ "name"=> "General","status"=>1,"created_at"=>now() ],
            [ "name"=> "Grant","status"=>1,"created_at"=>now() ],
            [ "name"=> "Home","status"=>1,"created_at"=>now() ],
            [ "name"=> "Insurance","status"=>1,"created_at"=>now() ],
            [ "name"=> "Jobs_Employment","status"=>1,"created_at"=>now() ],
            [ "name"=> "Kids","status"=>1,"created_at"=>now() ],
            [ "name"=> "Leadgen_a-brand","status"=>1,"created_at"=>now() ],
            [ "name"=> "Legal","status"=>1,"created_at"=>now() ],
            [ "name"=> "Male_Enhancement","status"=>1,"created_at"=>now() ],
            [ "name"=> "Mortgage","status"=>1,"created_at"=>now() ],
            [ "name"=> "Pain_Relief","status"=>1,"created_at"=>now() ],
            [ "name"=> "Payday_Loan","status"=>1,"created_at"=>now() ],
            [ "name"=> "Psychic","status"=>1,"created_at"=>now() ],
            [ "name"=> "Shopping","status"=>1,"created_at"=>now() ],
            [ "name"=> "Skin_Care","status"=>1,"created_at"=>now() ],
            [ "name"=> "Survey","status"=>1,"created_at"=>now() ],
            [ "name"=> "Sweepstake","status"=>1,"created_at"=>now() ],
            [ "name"=> "Travel","status"=>1,"created_at"=>now() ],
            [ "name"=> "Weight_Loss","status"=>1,"created_at"=>now() ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
