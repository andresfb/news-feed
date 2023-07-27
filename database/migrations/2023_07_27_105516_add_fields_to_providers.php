<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->json('display_counts')
                ->nullable()
                ->after('status');

            $table->integer('order')->default(0)
                ->after('display_counts');
        });
    }

    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('display_counts');

            $table->dropColumn('order');
        });
    }
};
