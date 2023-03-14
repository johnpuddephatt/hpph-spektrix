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
        Schema::create("products", function (Blueprint $table) {
            $table->string("id")->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger("published")->default(0);
            $table->tinyInteger("enabled")->default(0);
            $table->string("name");
            $table->string("slug");
            $table->text("description")->nullable();
            $table->string("price")->nullable();
            $table->string("postage")->nullable();
            $table->string("type")->nullable();
            $table->json("content")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("products");
    }
};
