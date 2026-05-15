<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'coordinator']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Application $application): bool
    {
        // Students can only view their own application
        if ($user->hasRole('student')) {
            return $application->student_id === $user->id;
        }

        // Coordinators and admins can view any application
        return $user->hasRole(['admin', 'coordinator']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only students can create applications
        return $user->hasRole('student');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Application $application): bool
    {
        // Only students can update their own pending applications
        if ($user->hasRole('student')) {
            return $application->student_id === $user->id && $application->status === 'pending';
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Application $application): bool
    {
        // Only students can withdraw their own pending applications
        if ($user->hasRole('student')) {
            return $application->student_id === $user->id && $application->status === 'pending';
        }

        // Admins can delete any application
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can approve the application.
     */
    public function approve(User $user, Application $application): bool
    {
        return $user->hasRole('coordinator') && $application->status === 'pending';
    }

    /**
     * Determine whether the user can reject the application.
     */
    public function reject(User $user, Application $application): bool
    {
        return $user->hasRole('coordinator') && $application->status === 'pending';
    }
}
