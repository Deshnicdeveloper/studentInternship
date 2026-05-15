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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships

    /**
     * Get the applications submitted by this student.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'student_id');
    }

    /**
     * Get the placements for this student.
     */
    public function placements(): HasMany
    {
        return $this->hasMany(Placement::class, 'student_id');
    }

    /**
     * Get the placements supervised by this user (supervisor).
     */
    public function supervisedPlacements(): HasMany
    {
        return $this->hasMany(Placement::class, 'supervisor_id');
    }

    /**
     * Get the placements coordinated by this user (coordinator).
     */
    public function coordinatedPlacements(): HasMany
    {
        return $this->hasMany(Placement::class, 'coordinator_id');
    }

    /**
     * Get the logbooks submitted by this student.
     */
    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class, 'student_id');
    }

    /**
     * Get the evaluations made by this user.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'evaluated_by');
    }

    /**
     * Get the documents uploaded by this user.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the applications reviewed by this user.
     */
    public function reviewedApplications(): HasMany
    {
        return $this->hasMany(Application::class, 'reviewed_by');
    }

    // Scopes

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include users with a specific role.
     */
    public function scopeByRole($query, string $role)
    {
        return $query->role($role);
    }

    /**
     * Scope a query to only include students.
     */
    public function scopeStudents($query)
    {
        return $query->role('student');
    }

    /**
     * Scope a query to only include supervisors.
     */
    public function scopeSupervisors($query)
    {
        return $query->role('supervisor');
    }

    /**
     * Scope a query to only include coordinators.
     */
    public function scopeCoordinators($query)
    {
        return $query->role('coordinator');
    }

    // Helper Methods

    /**
     * Get the current active placement for this student.
     */
    public function activePlacement()
    {
        return $this->placements()->where('status', 'active')->first();
    }

    /**
     * Get the current pending application for this student.
     */
    public function pendingApplication()
    {
        return $this->applications()->where('status', 'pending')->first();
    }

    /**
     * Check if the user has an active placement.
     */
    public function hasActivePlacement(): bool
    {
        return $this->placements()->where('status', 'active')->exists();
    }

    /**
     * Check if the user has a pending application.
     */
    public function hasPendingApplication(): bool
    {
        return $this->applications()->where('status', 'pending')->exists();
    }

    /**
     * Get the profile photo URL.
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
