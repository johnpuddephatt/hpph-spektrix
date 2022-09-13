<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("strands", function (Blueprint $table) {
            $table->id();
            $table->string("name", 50)->unique();
            $table->string("slug")->unique();
            $table->string("short_description")->nullable();
            $table->string("description")->nullable();
            $table->string("color", 7)->nullable();
            $table->text("content")->nullable();
            $table->text("logo")->nullable();
            $table->string("logo_text")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("strands");
    }
}
