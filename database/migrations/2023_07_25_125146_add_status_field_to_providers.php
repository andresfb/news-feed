<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('providers', static function (Blueprint $table) {
            $table->boolean('status')
                ->default(true)
                ->after('home_page');
        });
    }

    public function down(): void
    {
        Schema::table('providers', static function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
