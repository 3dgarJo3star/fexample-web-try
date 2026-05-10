<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crane_status_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crane_id');
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->boolean('is_on')->default(false);
            $table->boolean('is_working')->default(false);
            $table->string('location')->nullable();
            $table->decimal('diesel_level', 5, 2)->default(0);
            $table->decimal('hours_reading', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('logged_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crane_status_logs');
    }
};
