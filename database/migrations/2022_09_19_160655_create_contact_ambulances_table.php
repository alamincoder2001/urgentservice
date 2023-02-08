<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactAmbulancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_ambulances', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("ambulance_type");
            $table->string("email")->nullable();
            $table->string("phone");
            $table->string("departing_date");
            $table->string("to");
            $table->string("from");
            $table->string("trip");
            $table->unsignedBigInteger("ambulance_id");
            $table->foreign("ambulance_id")->references("id")->on("ambulances")->onDelete("cascade");
            $table->text("comment")->nullable();
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
        Schema::dropIfExists('contact_ambulances');
    }
}
