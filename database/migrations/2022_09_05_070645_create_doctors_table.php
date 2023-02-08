<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            //personal details
            $table->string("name");
            $table->string("username")->unique();
            $table->string("email");
            $table->string('password');
            $table->text("education");
            $table->text("concentration");
            $table->text("description")->nullable();
            $table->string("image")->nullable();
            //address details
            $table->string("phone");
            $table->string("first_fee");
            $table->string("second_fee");
            $table->foreignId('city_id')->constrained("districts", "id")->onDelete("cascade")->nullable();
            $table->string('hospital_id')->nullable();
            $table->string('diagnostic_id')->nullable();
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
        Schema::dropIfExists('doctors');
    }
}
