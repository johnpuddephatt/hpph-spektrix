<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("posts", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId("user_id")->constrained();
            $table->boolean("featured");
            $table->boolean("published")->default(false);
            $table->string("slug");
            $table->string("introduction", 300)->nullable();
            $table->string("subtitle", 100)->nullable();
            $table->string("title", 100);
            $table->text("content");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("posts");
    }
}
