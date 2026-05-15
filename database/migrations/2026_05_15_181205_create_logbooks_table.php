<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->integer('week_number');
            $table->date('week_start');
            $table->date('week_end');
            $table->text('activities');
            $table->text('learnings')->nullable();
            $table->text('challenges')->nullable();
            $table->text('next_week_plan')->nullable();
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->text('supervisor_feedback')->nullable();
            $table->timestamps();

            $table->unique(['placement_id', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
