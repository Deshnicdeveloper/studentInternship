<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Internship extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'title',
        'description',
        'slots',
        'start_date',
        'end_date',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    // Relationships

    /**
     * Get the company that owns this internship.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the applications for this internship.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the placements for this internship.
     */
    public function placements(): HasMany
    {
        return $this->hasMany(Placement::class);
    }

    // Scopes

    /**
     * Scope a query to only include active internships.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include internships with available slots.
     */
    public function scopeAvailable($query)
    {
        return $query->active()
            ->whereRaw('slots > (SELECT COUNT(*) FROM placements WHERE placements.internship_id = internships.id AND placements.status != "terminated")');
    }

    // Helper Methods

    /**
     * Get the number of approved placements.
     */
    public function getApprovedCountAttribute(): int
    {
        return $this->placements()->whereIn('status', ['active', 'completed'])->count();
    }

    /**
     * Get the number of available slots.
     */
    public function getAvailableSlotsAttribute(): int
    {
        return max(0, $this->slots - $this->approved_count);
    }

    /**
     * Check if the internship has available slots.
     */
    public function hasAvailableSlots(): bool
    {
        return $this->available_slots > 0;
    }

    /**
     * Get the duration in weeks.
     */
    public function getDurationInWeeksAttribute(): int
    {
        return $this->start_date->diffInWeeks($this->end_date);
    }

    /**
     * Get pending applications count.
     */
    public function getPendingApplicationsCountAttribute(): int
    {
        return $this->applications()->where('status', 'pending')->count();
    }
}
