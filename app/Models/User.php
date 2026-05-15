<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'student_id',
        'phone',
        'department',
        'profile_photo',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'student_id');
    }

    public function placements(): HasMany
    {
        return $this->hasMany(Placement::class, 'student_id');
    }

    public function supervisedPlacements(): HasMany
    {
        return $this->hasMany(Placement::class, 'supervisor_id');
    }

    public function coordinatedPlacements(): HasMany
    {
        return $this->hasMany(Placement::class, 'coordinator_id');
    }

    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class, 'student_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'evaluated_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeStudents($query)
    {
        return $query->role('student');
    }

    public function scopeSupervisors($query)
    {
        return $query->role('supervisor');
    }

    public function scopeCoordinators($query)
    {
        return $query->role('coordinator');
    }

    // Accessors
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    // Helper Methods
    public function hasActivePlacement(): bool
    {
        return $this->placements()->where('status', 'active')->exists();
    }

    public function hasPendingApplication(): bool
    {
        return $this->applications()->where('status', 'pending')->exists();
    }
}
