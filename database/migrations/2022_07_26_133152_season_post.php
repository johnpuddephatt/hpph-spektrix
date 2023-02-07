<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("post_season", function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->unsignedBigInteger("season_id");
            $table
                ->foreign("season_id")
                ->references("id")
                ->on("seasons");
            $table->unsignedBigInteger("post_id");
            $table
                ->foreign("post_id")
                ->references("id")
                ->on("posts");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
