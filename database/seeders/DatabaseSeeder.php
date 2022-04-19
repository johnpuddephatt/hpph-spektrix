<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $strands = array_map(function ($value) {
            return ["name" => $value];
        }, config("hpph.strands"));
        DB::table("strands")->insertOrIgnore($strands);
    }
}
