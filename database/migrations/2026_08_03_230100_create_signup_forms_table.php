<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * A named set of signup options, so the same form can be placed on several
     * pages while different pages offer different tags.
     *
     * tags/statements are JSON arrays of Spektrix ids rather than pivot tables
     * because their order is the order they appear in the form.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("signup_forms", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->string("heading")->nullable();
            $table->text("intro")->nullable();
            $table->text("success_message")->nullable();
            $table->json("tags")->nullable();
            $table->json("statements")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("signup_forms");
    }
};
