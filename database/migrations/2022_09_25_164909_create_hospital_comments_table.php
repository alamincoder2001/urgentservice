<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("hospital_id");
            $table->foreign("hospital_id")->references("id")->on("hospitals")->onDelete("cascade");
            $table->integer("contact_id");
            $table->longText("hospital_comment");
            $table->longText("client_comment")->nullable();
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
        Schema::dropIfExists('hospital_comments');
    }
}
