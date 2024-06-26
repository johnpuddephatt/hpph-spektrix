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
        Schema::create("pages", function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->string("name");
            $table->string("slug");
            $table->boolean("published")->default(false);
            $table->string("subtitle", 30)->nullable();
            $table->string("introduction", 200)->nullable();
            $table->string("template");
            $table->json("content")->nullable();
            $table
                ->bigInteger("parent_id")
                ->unsigned()
                ->nullable();
            $table
                ->foreign("parent_id")
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
        Schema::dropIfExists("page");
    }
};
