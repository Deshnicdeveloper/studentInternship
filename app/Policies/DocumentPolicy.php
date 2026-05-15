<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view documents in their context
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        // Users can only view their own documents
        if ($user->hasRole('student')) {
            return $document->user_id === $user->id;
        }

        // Supervisors can view documents of their assigned students
        if ($user->hasRole('supervisor') && $document->placement_id) {
            return $document->placement->supervisor_id === $user->id;
        }

        // Coordinators and admins can view any document
        return $user->hasRole(['admin', 'coordinator']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only students can upload documents
        return $user->hasRole('student');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        // Students can only update their own documents
        if ($user->hasRole('student')) {
            return $document->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        // Students can only delete their own documents
        if ($user->hasRole('student')) {
            return $document->user_id === $user->id;
        }

        // Admins can delete any document
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can download the document.
     */
    public function download(User $user, Document $document): bool
    {
        return $this->view($user, $document);
    }
}
