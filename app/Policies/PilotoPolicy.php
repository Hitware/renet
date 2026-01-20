<?php

namespace App\Policies;

use App\Models\Piloto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PilotoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Cualquier usuario autenticado puede ver la lista (solo verá su propio perfil)
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Piloto $piloto): bool
    {
        // Admins e inspectores pueden ver cualquier perfil
        if ($user->isAdmin() || $user->isInspector()) {
            return true;
        }

        // Un usuario solo puede ver su propio perfil de piloto
        return $user->piloto_id === $piloto->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo usuarios empresa o publico pueden crear perfil de piloto
        // Y solo si no tienen uno ya creado
        return ($user->isEmpresa() || $user->isPublico()) && !$user->piloto_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Piloto $piloto): bool
    {
        // Admins pueden actualizar cualquier perfil
        if ($user->isAdmin()) {
            return true;
        }

        // Un usuario solo puede actualizar su propio perfil de piloto
        return $user->piloto_id === $piloto->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Piloto $piloto): bool
    {
        // Solo admins pueden eliminar perfiles
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Piloto $piloto): bool
    {
        // Solo admins pueden restaurar perfiles
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Piloto $piloto): bool
    {
        // Solo admins pueden eliminar permanentemente
        return $user->isAdmin();
    }
}
