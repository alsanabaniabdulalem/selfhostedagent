<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag')->unique();
            $table->string('name');
            $table->string('category');
            $table->string('serial_number')->nullable();

            // Status drives assignment rules and dashboard counts.
            $table->enum('status', ['available', 'assigned', 'maintenance', 'retired'])
                ->default('available');

            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
