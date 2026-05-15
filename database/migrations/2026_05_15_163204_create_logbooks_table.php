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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->integer('week_number');
            $table->text('activities')->nullable();
            $table->text('challenges')->nullable();
            $table->text('skills_gained')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status', ['draft', 'submitted', 'reviewed'])->default('draft');
            $table->text('coordinator_comment')->nullable();
            $table->text('supervisor_comment')->nullable();
            $table->boolean('is_flagged')->default(false);
            $table->timestamps();

            // A student can only have one logbook entry per week per placement
            $table->unique(['placement_id', 'week_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
