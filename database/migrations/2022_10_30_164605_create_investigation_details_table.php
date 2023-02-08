<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestigationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investigation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("investigation_id");
            $table->foreign("investigation_id")->references("id")->on("investigations")->onDelete("cascade");
            $table->string("name");
            $table->string("price");
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
        Schema::dropIfExists('investigation_details');
    }
}
