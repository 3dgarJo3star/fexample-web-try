<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cranes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('serial_number')->nullable();
            $table->string('brand')->default('Titán');
            $table->unsignedSmallInteger('year')->nullable();
            $table->decimal('capacity_tons', 8, 2)->nullable();
            $table->string('status')->default('available');
            $table->string('current_location')->nullable();
            $table->decimal('diesel_level', 5, 2)->default(0);
            $table->decimal('total_hours', 10, 2)->default(0);
            $table->decimal('last_maintenance_hours', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cranes');
    }
};
