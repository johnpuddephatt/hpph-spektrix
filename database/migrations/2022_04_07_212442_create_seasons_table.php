<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("seasons", function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table
                ->string("slug")
                ->unique()
                ->nullable();
            $table->string("name", 50)->unique();
            $table->boolean("enabled")->default(false);
            $table->boolean("published")->default(false);
            $table->string("short_description")->nullable();
            $table->text("description")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("seasons");
    }
}
