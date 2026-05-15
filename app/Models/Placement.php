<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Placement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'application_id',
        'student_id',
        'internship_id',
        'supervisor_id',
        'coordinator_id',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    // Relationships

    /**
     * Get the application for this placement.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the student for this placement.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the internship for this placement.
     */
    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    /**
     * Get the supervisor for this placement.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get the coordinator for this placement.
     */
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    /**
     * Get the logbooks for this placement.
     */
    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class);
    }

    /**
     * Get the evaluations for this placement.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Get the documents for this placement.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    // Scopes

    /**
     * Scope a query to only include active placements.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include completed placements.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include terminated placements.
     */
    public function scopeTerminated($query)
    {
        return $query->where('status', 'terminated');
    }

    // Helper Methods

    /**
     * Check if the placement is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the placement is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Get the duration in weeks.
     */
    public function getDurationInWeeksAttribute(): int
    {
        return $this->start_date->diffInWeeks($this->end_date);
    }

    /**
     * Get the current week number of the placement.
     */
    public function getCurrentWeekAttribute(): int
    {
        if (now()->lt($this->start_date)) {
            return 0;
        }

        if (now()->gt($this->end_date)) {
            return $this->duration_in_weeks;
        }

        return $this->start_date->diffInWeeks(now()) + 1;
    }

    /**
     * Get the logbook completion percentage.
     */
    public function getLogbookCompletionPercentageAttribute(): float
    {
        $totalWeeks = $this->duration_in_weeks;

        if ($totalWeeks === 0) {
            return 0;
        }

        $submittedWeeks = $this->logbooks()->whereIn('status', ['submitted', 'reviewed'])->count();

        return round(($submittedWeeks / $totalWeeks) * 100, 1);
    }

    /**
     * Get the midterm evaluation.
     */
    public function midtermEvaluation()
    {
        return $this->evaluations()->where('type', 'midterm')->first();
    }

    /**
     * Get the final evaluation.
     */
    public function finalEvaluation()
    {
        return $this->evaluations()->where('type', 'final')->first();
    }

    /**
     * Check if midterm evaluation is submitted.
     */
    public function hasMidtermEvaluation(): bool
    {
        return $this->evaluations()->where('type', 'midterm')->exists();
    }

    /**
     * Check if final evaluation is submitted.
     */
    public function hasFinalEvaluation(): bool
    {
        return $this->evaluations()->where('type', 'final')->exists();
    }
}
