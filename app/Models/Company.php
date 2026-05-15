<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'industry',
        'contact_person',
        'contact_email',
        'contact_phone',
        'website',
        'logo',
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
            'is_active' => 'boolean',
        ];
    }

    // Relationships

    /**
     * Get the internships for this company.
     */
    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class);
    }

    /**
     * Get all placements through internships for this company.
     */
    public function placements(): HasManyThrough
    {
        return $this->hasManyThrough(Placement::class, Internship::class);
    }

    // Scopes

    /**
     * Scope a query to only include active companies.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper Methods

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the count of active internships.
     */
    public function getActiveInternshipsCountAttribute(): int
    {
        return $this->internships()->where('is_active', true)->count();
    }

    /**
     * Get the count of total placements.
     */
    public function getTotalPlacementsCountAttribute(): int
    {
        return $this->placements()->count();
    }
}
