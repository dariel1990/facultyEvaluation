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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('academic_id')->references('id')->on('academic_years')->restrictOnDelete();
            $table->foreignId('faculty_id')->references('id')->on('faculties')->restrictOnDelete();
            $table->enum('type', ['Student', 'Peer', 'Supervisor'])->nullable(); // 0 - Student, 1 - Peer, 2 - Supervisor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
