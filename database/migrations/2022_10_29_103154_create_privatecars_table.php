<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivatecarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privatecars', function (Blueprint $table) {
            $table->id();
            $table->string("name", 150);
            $table->string("username");
            $table->string("password");
            $table->string("cartype_id");
            $table->string("phone");
            $table->string("email");
            $table->text("map_link")->nullable();
            $table->integer('city_id');
            $table->integer('upazila_id');
            $table->string("address");
            $table->string("car_license")->nullable();
            $table->string("driver_license")->nullable();
            $table->string("driver_nid")->nullable();
            $table->string("driver_address")->nullable();
            $table->string("number_of_seat")->nullable();
            $table->string("image")->nullable();
            $table->longText("description")->nullable(); 
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
        Schema::dropIfExists('privatecars');
    }
}
