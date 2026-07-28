<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance_strand', function (Blueprint $table) {
            $table->string('instance_id');
            $table->foreignId('strand_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('position')->default(1);

            $table
                ->foreign('instance_id')
                ->references('id')
                ->on('instances')
                ->cascadeOnDelete();

            $table->unique(['instance_id', 'strand_id']);
            $table->index('strand_id');
        });

        Schema::create('instance_season', function (Blueprint $table) {
            $table->string('instance_id');
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('position')->default(1);

            $table
                ->foreign('instance_id')
                ->references('id')
                ->on('instances')
                ->cascadeOnDelete();

            $table->unique(['instance_id', 'season_id']);
            $table->index('season_id');
        });

        // Backfill the pivots from the existing single string columns (position 1),
        // so there is no data gap before the next hourly Spektrix sync.
        DB::statement('
            INSERT INTO instance_strand (instance_id, strand_id, position)
            SELECT i.id, s.id, 1
            FROM instances i
            INNER JOIN strands s ON s.name = i.strand_name
            WHERE i.strand_name IS NOT NULL
        ');

        DB::statement('
            INSERT INTO instance_season (instance_id, season_id, position)
            SELECT i.id, se.id, 1
            FROM instances i
            INNER JOIN seasons se ON se.name = i.season_name
            WHERE i.season_name IS NOT NULL
        ');

        Schema::table('instances', function (Blueprint $table) {
            $table->dropForeign(['strand_name']);
            $table->dropIndex(['strand_name']);
            $table->dropForeign(['season_name']);
            $table->dropColumn(['strand_name', 'season_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->string('season_name')->nullable();
            $table
                ->foreign('season_name')
                ->references('name')
                ->on('seasons');

            $table->string('strand_name')->nullable();
            $table
                ->foreign('strand_name')
                ->references('name')
                ->on('strands');
            $table->index('strand_name');
        });

        // Restore the primary (position 1) strand/season into the string columns.
        DB::statement('
            UPDATE instances i
            INNER JOIN instance_strand ist ON ist.instance_id = i.id AND ist.position = 1
            INNER JOIN strands s ON s.id = ist.strand_id
            SET i.strand_name = s.name
        ');

        DB::statement('
            UPDATE instances i
            INNER JOIN instance_season ise ON ise.instance_id = i.id AND ise.position = 1
            INNER JOIN seasons se ON se.id = ise.season_id
            SET i.season_name = se.name
        ');

        Schema::dropIfExists('instance_strand');
        Schema::dropIfExists('instance_season');
    }
};
