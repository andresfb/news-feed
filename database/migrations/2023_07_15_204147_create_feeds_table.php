<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feeds', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')
                ->constrained('providers')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('url', 500);
            $table->boolean('status')->default(true);
            $table->dateTime('refreshed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['provider_id', 'status', 'refreshed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
