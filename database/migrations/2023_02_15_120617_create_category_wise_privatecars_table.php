<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryWisePrivatecarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_wise_privatecars', function (Blueprint $table) {
            $table->id();
            $table->foreignId("privatecar_id")->constrained('privatecars', 'id')->onDelete('cascade');
            $table->integer("cartype_id");
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
        Schema::dropIfExists('category_wise_privatecars');
    }
}
