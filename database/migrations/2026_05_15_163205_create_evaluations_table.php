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
            $table->id();
            $table->foreignId('placement_id')->constrained()->onDelete('cascade');
            $table->foreignId('evaluated_by')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['midterm', 'final']);
            $table->json('scores')->nullable();
            $table->text('comments')->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            // One evaluation per type per placement
            $table->unique(['placement_id', 'type']);
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
