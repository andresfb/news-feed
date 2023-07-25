<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', static function (Blueprint $table) {
            $table->dropColumn('data');
        });

        Schema::table('articles', static function (Blueprint $table) {
            $table->json('data')
                ->nullable()
                ->after('thumbnail');
        });
    }

    public function down(): void
    {
        Schema::table('articles', static function (Blueprint $table) {
            $table->dropColumn('data');
            $table->longText('data')
                ->nullable()
                ->after('thumbnail');
        });

        Schema::table('articles', static function (Blueprint $table) {
            $table->longText('data')
                ->nullable()
                ->after('thumbnail');
        });
    }
};
