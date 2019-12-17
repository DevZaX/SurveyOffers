<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OfferTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_template', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("offer_id");
            $table->unsignedBigInteger("template_id");
            $table->foreign("offer_id")->references("id")->on("offers");
            $table->foreign("template_id")->references("id")->on("templates");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_template');
    }
}
