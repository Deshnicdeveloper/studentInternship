<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\Placement;
use App\Models\User;

class EvaluationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view evaluations in their context
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Evaluation $evaluation): bool
    {
        // Students can only view evaluations for their own placement
        if ($user->hasRole('student')) {
            return $evaluation->placement->student_id === $user->id;
        }

        // Supervisors can only view evaluations they submitted
        if ($user->hasRole('supervisor')) {
            return $evaluation->evaluated_by === $user->id;
        }

        // Coordinators and admins can view any evaluation
        return $user->hasRole(['admin', 'coordinator']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Placement $placement): bool
    {
        // Only supervisors can create evaluations for their assigned students
        if ($user->hasRole('supervisor')) {
            return $placement->supervisor_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Evaluation $evaluation): bool
    {
        // Evaluations cannot be updated once submitted
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Evaluation $evaluation): bool
    {
        // Only admins can delete evaluations
        return $user->hasRole('admin');
    }
}
