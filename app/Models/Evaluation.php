<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'placement_id',
        'evaluated_by',
        'type',
        'technical_skills',
        'communication',
        'teamwork',
        'punctuality',
        'initiative',
        'total_score',
        'grade',
        'strengths',
        'areas_for_improvement',
        'comments',
    ];

    protected function casts(): array
    {
        return [
            'technical_skills' => 'integer',
            'communication' => 'integer',
            'teamwork' => 'integer',
            'punctuality' => 'integer',
            'initiative' => 'integer',
            'total_score' => 'decimal:2',
        ];
    }

    // Relationships
    public function placement(): BelongsTo
    {
        return $this->belongsTo(Placement::class);
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }

    // Scopes
    public function scopeMidterm($query)
    {
        return $query->where('type', 'midterm');
    }

    public function scopeFinal($query)
    {
        return $query->where('type', 'final');
    }

    // Helper to calculate grade
    public function calculateGrade(): string
    {
        if ($this->total_score >= 90) return 'A';
        if ($this->total_score >= 80) return 'B';
        if ($this->total_score >= 70) return 'C';
        if ($this->total_score >= 60) return 'D';
        return 'F';
    }
}
