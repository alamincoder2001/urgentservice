<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string("appointment_date");
            $table->bigInteger('doctor_id')->unsigned();
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->bigInteger('hospital_id')->unsigned()->nullable();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->bigInteger('diagnostic_id')->unsigned()->nullable();
            $table->foreign('diagnostic_id')->references('id')->on('diagnostics')->onDelete('cascade');
            $table->text("problem")->nullable();
            $table->string("patient_type", 50)->nullable();
            $table->string("name");
            $table->string("age");
            $table->string("district");
            $table->string("upozila");
            $table->string("contact");
            $table->string("email")->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
