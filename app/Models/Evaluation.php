<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'placement_id',
        'evaluated_by',
        'type',
        'scores',
        'comments',
        'total_score',
        'submitted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scores' => 'array',
            'total_score' => 'decimal:2',
            'submitted_at' => 'datetime',
        ];
    }

    /**
     * Default evaluation criteria with max scores.
     */
    public const CRITERIA = [
        'punctuality' => ['label' => 'Punctuality & Attendance', 'max' => 20],
        'technical_skills' => ['label' => 'Technical Skills', 'max' => 20],
        'communication' => ['label' => 'Communication Skills', 'max' => 20],
        'initiative' => ['label' => 'Initiative & Creativity', 'max' => 20],
        'overall' => ['label' => 'Overall Performance', 'max' => 20],
    ];

    // Relationships

    /**
     * Get the placement for this evaluation.
     */
    public function placement(): BelongsTo
    {
        return $this->belongsTo(Placement::class);
    }

    /**
     * Get the user who submitted this evaluation.
     */
    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }

    // Scopes

    /**
     * Scope a query to only include midterm evaluations.
     */
    public function scopeMidterm($query)
    {
        return $query->where('type', 'midterm');
    }

    /**
     * Scope a query to only include final evaluations.
     */
    public function scopeFinal($query)
    {
        return $query->where('type', 'final');
    }

    // Helper Methods

    /**
     * Check if the evaluation is midterm.
     */
    public function isMidterm(): bool
    {
        return $this->type === 'midterm';
    }

    /**
     * Check if the evaluation is final.
     */
    public function isFinal(): bool
    {
        return $this->type === 'final';
    }

    /**
     * Calculate the total score from individual scores.
     */
    public function calculateTotalScore(): float
    {
        if (!$this->scores || !is_array($this->scores)) {
            return 0;
        }

        return array_sum($this->scores);
    }

    /**
     * Get the maximum possible score.
     */
    public function getMaxScoreAttribute(): int
    {
        return array_sum(array_column(self::CRITERIA, 'max'));
    }

    /**
     * Get the percentage score.
     */
    public function getPercentageScoreAttribute(): float
    {
        if ($this->max_score === 0) {
            return 0;
        }

        return round(($this->total_score / $this->max_score) * 100, 1);
    }

    /**
     * Get the grade based on percentage score.
     */
    public function getGradeAttribute(): string
    {
        $percentage = $this->percentage_score;

        return match (true) {
            $percentage >= 90 => 'A+',
            $percentage >= 80 => 'A',
            $percentage >= 70 => 'B',
            $percentage >= 60 => 'C',
            $percentage >= 50 => 'D',
            default => 'F',
        };
    }
}
