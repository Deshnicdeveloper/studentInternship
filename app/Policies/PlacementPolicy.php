<?php

namespace App\Policies;

use App\Models\Placement;
use App\Models\User;

class PlacementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'coordinator', 'supervisor']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Placement $placement): bool
    {
        // Students can only view their own placement
        if ($user->hasRole('student')) {
            return $placement->student_id === $user->id;
        }

        // Supervisors can only view placements assigned to them
        if ($user->hasRole('supervisor')) {
            return $placement->supervisor_id === $user->id;
        }

        // Coordinators and admins can view any placement
        return $user->hasRole(['admin', 'coordinator']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Placement $placement): bool
    {
        return $user->hasRole(['admin', 'coordinator']);
    }

    /**
     * Determine whether the user can complete the placement.
     */
    public function complete(User $user, Placement $placement): bool
    {
        return $user->hasRole('coordinator') && $placement->status === 'active';
    }

    /**
     * Determine whether the user can terminate the placement.
     */
    public function terminate(User $user, Placement $placement): bool
    {
        return $user->hasRole('coordinator') && $placement->status === 'active';
    }

    /**
     * Determine whether the user can grade the placement.
     */
    public function grade(User $user, Placement $placement): bool
    {
        return $user->hasRole('coordinator');
    }
}
