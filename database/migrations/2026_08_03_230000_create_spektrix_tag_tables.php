<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Local copies of the web-visible Spektrix tag groups, tags and statements.
     *
     * Ids are the Spektrix ids, as with events, funds and memberships. Rows are
     * never deleted by the sync — anything missing from a fetch is marked
     * disabled, so an editor's selection survives a tag being temporarily
     * withdrawn and restored in Spektrix.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("spektrix_tag_groups", function (Blueprint $table) {
            $table->string("id")->primary();
            $table->timestamps();
            $table->boolean("enabled")->default(false);
            $table->string("name");
            $table->text("description")->nullable();
        });

        Schema::create("spektrix_tags", function (Blueprint $table) {
            $table->string("id")->primary();
            $table->timestamps();
            $table->boolean("enabled")->default(false);
            $table->string("name");
            $table
                ->string("spektrix_tag_group_id")
                ->nullable()
                ->index();
        });

        Schema::create("spektrix_statements", function (Blueprint $table) {
            $table->string("id")->primary();
            $table->timestamps();
            $table->boolean("enabled")->default(false);
            $table->text("text");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("spektrix_tags");
        Schema::dropIfExists("spektrix_tag_groups");
        Schema::dropIfExists("spektrix_statements");
    }
};
