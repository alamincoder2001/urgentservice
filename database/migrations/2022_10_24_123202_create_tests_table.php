<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("admin_id")->nullable();
            $table->foreign("admin_id")->references("id")->on("admins")->onDelete("cascade");
            $table->unsignedBigInteger("hospital_id")->nullable();
            $table->foreign("hospital_id")->references("id")->on("hospitals")->onDelete("cascade");
            $table->unsignedBigInteger("diagnostic_id")->nullable();
            $table->foreign("diagnostic_id")->references("id")->on("diagnostics")->onDelete("cascade");
            $table->string("name");
            $table->integer("amount");
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
        Schema::dropIfExists('tests');
    }
}
