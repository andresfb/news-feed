<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_id')
                ->constrained('feeds');
            $table->string('title', 500);
            $table->string('permalink', 500);
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->longText('data')->nullable();
            $table->dateTime('read_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
