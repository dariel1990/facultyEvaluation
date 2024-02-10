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
        Schema::create('student_assigned_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('evaluation_id');
            $table->boolean('hasCompleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assigned_evaluations');
    }
};
