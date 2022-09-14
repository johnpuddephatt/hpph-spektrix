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
        Schema::create("opportunities", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean("published")->default(false);
            $table->string("title", 40);
            $table->string("slug");
            $table->string("type");
            $table->string("hours", 40)->nullable();
            $table->string("application_deadline", 40)->nullable();
            $table->string("salary", 40)->nullable();
            $table->string("responsible_to", 40)->nullable();
            $table->string("probation_period", 40)->nullable();
            $table->string("notice_period", 40)->nullable();
            $table->string("holidays", 40)->nullable();
            $table->string("summary", 300);
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
        Schema::dropIfExists("jobs");
    }
};
