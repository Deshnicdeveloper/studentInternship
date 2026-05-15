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
        'scores',
        'total_score',
        'comments',
        'strengths',
        'improvements',
    ];

    protected function casts(): array
    {
        return [
            'scores' => 'array',
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
}
