<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Logbook extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'placement_id',
        'student_id',
        'week_number',
        'activities',
        'challenges',
        'skills_gained',
        'submitted_at',
        'status',
        'coordinator_comment',
        'supervisor_comment',
        'is_flagged',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'is_flagged' => 'boolean',
        ];
    }

    // Relationships

    /**
     * Get the placement for this logbook.
     */
    public function placement(): BelongsTo
    {
        return $this->belongsTo(Placement::class);
    }

    /**
     * Get the student who submitted this logbook.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Scopes

    /**
     * Scope a query to only include draft logbooks.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include submitted logbooks.
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * Scope a query to only include reviewed logbooks.
     */
    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    /**
     * Scope a query to only include flagged logbooks.
     */
    public function scopeFlagged($query)
    {
        return $query->where('is_flagged', true);
    }

    /**
     * Scope a query to only include pending review logbooks (submitted but not reviewed).
     */
    public function scopePendingReview($query)
    {
        return $query->where('status', 'submitted');
    }

    // Helper Methods

    /**
     * Check if the logbook is a draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if the logbook is submitted.
     */
    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    /**
     * Check if the logbook is reviewed.
     */
    public function isReviewed(): bool
    {
        return $this->status === 'reviewed';
    }

    /**
     * Submit the logbook.
     */
    public function submit(): void
    {
        $this->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);
    }

    /**
     * Mark the logbook as reviewed.
     */
    public function markAsReviewed(): void
    {
        $this->update([
            'status' => 'reviewed',
        ]);
    }

    /**
     * Flag the logbook.
     */
    public function flag(): void
    {
        $this->update([
            'is_flagged' => true,
        ]);
    }

    /**
     * Unflag the logbook.
     */
    public function unflag(): void
    {
        $this->update([
            'is_flagged' => false,
        ]);
    }
}
