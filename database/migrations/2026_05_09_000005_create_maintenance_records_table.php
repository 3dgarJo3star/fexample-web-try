<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crane_id');
            $table->string('type')->default('preventive');
            $table->decimal('hours_at_maintenance', 10, 2);
            $table->decimal('next_maintenance_hours', 10, 2);
            $table->date('scheduled_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->text('description');
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_records');
    }
};
