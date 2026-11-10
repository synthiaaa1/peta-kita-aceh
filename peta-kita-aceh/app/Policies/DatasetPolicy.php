<?php

namespace App\Policies;

use App\Models\Dataset;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DatasetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Dataset $dataset): bool
    {
        if ($user->isAdmin()) return true;

        // Operator sees their own
        if ($user->agency_id && $user->agency_id === $dataset->agency_id) {
            return true;
        }

        // Otherwise only published + public/restricted logic
        return Dataset::accessibleBy($user)->where('id', $dataset->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Dataset $dataset): bool
    {
        if ($user->isAdmin()) return true;
        
        return $user->isOperator() && $user->agency_id === $dataset->agency_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dataset $dataset): bool
    {
        if ($user->isAdmin()) return true;
        
        return $user->isOperator() && $user->agency_id === $dataset->agency_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Dataset $dataset): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Dataset $dataset): bool
    {
        return $user->isAdmin();
    }
}
