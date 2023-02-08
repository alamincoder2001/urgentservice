<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSittimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sittimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("doctor_id")->constrained("doctors", "id")->onDelete("cascade");
            $table->string("day");
            $table->string("from");
            $table->string("to");
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
        Schema::dropIfExists('sittimes');
    }
}
