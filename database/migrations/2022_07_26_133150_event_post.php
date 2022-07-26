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
        Schema::create("event_post", function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->string("event_id");
            $table
                ->foreign("event_id")
                ->references("id")
                ->on("events");
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
