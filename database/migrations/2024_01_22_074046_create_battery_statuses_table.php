<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('battery_statuses', function (Blueprint $table) {
            $table->id();
            $table->float('status', 5, 2)->nullable(false)->default(0.00);
            $table->foreignId('sensor_id')->constrained('sensors');
            $table->timestampTz('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battery_statuses');
    }
};
