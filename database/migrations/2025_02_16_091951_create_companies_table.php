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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 124)->nullable(false)->unique();
            $table->string('address', 124)->nullable()->default('');
            $table->string('city', 50)->nullable()->default('');
            $table->string('postcode', 4)->nullable(false);
            $table->string('country', 50)->nullable(false)->default('Slovenija');
            $table->string('contact_email', 255)->nullable(false)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
