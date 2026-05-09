<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('crane_id');
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->string('service_location');
            $table->date('start_date');
            $table->time('arrival_time')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->time('departure_time')->nullable();
            $table->string('status')->default('pending');
            $table->string('payment_method')->default('cash');
            $table->string('authorized_by_name')->nullable();
            $table->string('authorized_by_phone')->nullable();
            $table->boolean('client_signature')->default(false);
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_orders');
    }
};
