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
            $table->softDeletes();
            $table->string("name", 50)->unique();
            $table
                ->string("slug")
                ->unique()
                ->nullable();
            $table->boolean("published")->default(false);
            $table->boolean("enabled")->default(false);
            $table->string("short_description")->nullable();
            $table->string("description")->nullable();
            $table->string("color")->nullable();
            $table->text("content")->nullable();
            $table->text("logo")->nullable();
            $table->text("logo_simple")->nullable();
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
