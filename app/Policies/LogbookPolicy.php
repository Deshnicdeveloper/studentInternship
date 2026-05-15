<?php

namespace App\Policies;

use App\Models\Logbook;
use App\Models\User;

class LogbookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view logbooks in their context
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Logbook $logbook): bool
    {
        // Students can only view their own logbooks
        if ($user->hasRole('student')) {
            return $logbook->student_id === $user->id;
        }

        // Supervisors can only view logbooks of their assigned students
        if ($user->hasRole('supervisor')) {
            return $logbook->placement->supervisor_id === $user->id;
        }

        // Coordinators and admins can view any logbook
        return $user->hasRole(['admin', 'coordinator']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only students can create logbooks
        return $user->hasRole('student');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Logbook $logbook): bool
    {
        // Only students can update their own draft or rejected logbooks
        if ($user->hasRole('student')) {
            return $logbook->student_id === $user->id &&
                   in_array($logbook->status, ['draft', 'rejected']);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Logbook $logbook): bool
    {
        // Only students can delete their own draft logbooks
        if ($user->hasRole('student')) {
            return $logbook->student_id === $user->id && $logbook->status === 'draft';
        }

        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can review the logbook.
     */
    public function review(User $user, Logbook $logbook): bool
    {
        // Supervisors can review logbooks of their assigned students
        if ($user->hasRole('supervisor')) {
            return $logbook->placement->supervisor_id === $user->id &&
                   $logbook->status === 'submitted';
        }

        // Coordinators can review any submitted logbook
        if ($user->hasRole('coordinator')) {
            return $logbook->status === 'submitted';
        }

        return false;
    }
}
