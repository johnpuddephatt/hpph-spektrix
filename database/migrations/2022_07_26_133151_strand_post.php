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
        Schema::create("post_strand", function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->unsignedBigInteger("strand_id");
            $table
                ->foreign("strand_id")
                ->references("id")
                ->on("strands");
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
