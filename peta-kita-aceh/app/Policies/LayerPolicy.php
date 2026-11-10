<?php

namespace App\Policies;

use App\Models\Layer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LayerPolicy
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
    public function view(User $user, Layer $layer): bool
    {
        if ($user->isAdmin()) return true;

        if ($user->agency_id && $layer->dataset && $user->agency_id === $layer->dataset->agency_id) {
            return true;
        }

        return \App\Models\Dataset::accessibleBy($user)->where('id', $layer->dataset_id)->exists();
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
    public function update(User $user, Layer $layer): bool
    {
        if ($user->isAdmin()) return true;

        return $user->isOperator() && $layer->dataset && $user->agency_id === $layer->dataset->agency_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Layer $layer): bool
    {
        if ($user->isAdmin()) return true;

        return $user->isOperator() && $layer->dataset && $user->agency_id === $layer->dataset->agency_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Layer $layer): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Layer $layer): bool
    {
        return $user->isAdmin();
    }
}
