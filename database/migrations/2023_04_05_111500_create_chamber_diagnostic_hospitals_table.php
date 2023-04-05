<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamberDiagnosticHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamber_diagnostic_hospitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId("doctor_id")->constrained("doctors", "id")->onDelete("cascade");
            $table->string("type", 50);
            $table->string("chamber_name")->nullable();
            $table->string("chamber_address")->nullable();
            $table->integer("hospital_id")->nullable();
            $table->integer("diagnostic_id")->nullable();
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
        Schema::dropIfExists('chamber_diagnostic_hospitals');
    }
}
