<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactPrivatecarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_privatecars', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("privatecar_type");
            $table->string("email")->nullable();
            $table->string("phone");
            $table->string("departing_date");
            $table->string("to");
            $table->string("from");
            $table->string("trip");
            $table->unsignedBigInteger("privatecar_id");
            $table->foreign("privatecar_id")->references("id")->on("privatecars")->onDelete("cascade");
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
        Schema::dropIfExists('contact_privatecars');
    }
}
