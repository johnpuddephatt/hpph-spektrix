<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("pages", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("slug");
            $table->string("title");
            $table->string("header_type");
            $table->string("header_position");
            $table->text("content")->nullable();
            $table
                ->bigInteger("parent_page_id")
                ->unsigned()
                ->nullable();
            $table
                ->foreign("parent_page_id")
                ->references("id")
                ->on("pages");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("pages");
    }
}
