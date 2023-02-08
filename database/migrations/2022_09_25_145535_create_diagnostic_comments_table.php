<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostic_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("diagnostic_id");
            $table->foreign("diagnostic_id")->references("id")->on("diagnostics")->onDelete("cascade");
            $table->integer("contact_id");
            $table->longText("diagnostic_comment");
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
        Schema::dropIfExists('diagnostic_comments');
    }
}
