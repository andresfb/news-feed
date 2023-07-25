<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $path = Storage::disk('public')->path('newsroom.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
