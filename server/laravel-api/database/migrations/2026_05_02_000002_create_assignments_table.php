<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipments')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // assigned_at is explicit so client can backfill historical assignments.
            $table->date('assigned_at');
            $table->date('due_at')->nullable();
            $table->date('returned_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['equipment_id', 'returned_at']);
            $table->index(['due_at', 'returned_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
