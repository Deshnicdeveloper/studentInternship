<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_id')->constrained()->cascadeOnDelete();
            $table->foreignId('evaluated_by')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['midterm', 'final']);
            $table->tinyInteger('technical_skills')->unsigned()->nullable();
            $table->tinyInteger('communication')->unsigned()->nullable();
            $table->tinyInteger('teamwork')->unsigned()->nullable();
            $table->tinyInteger('punctuality')->unsigned()->nullable();
            $table->tinyInteger('initiative')->unsigned()->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->string('grade', 2)->nullable();
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->unique(['placement_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
