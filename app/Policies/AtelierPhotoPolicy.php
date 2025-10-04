<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AtelierPhoto;
use Illuminate\Auth\Access\Response;

class AtelierPhotoPolicy
{
    /**
     * Дозволяє будь-якому користувачу (включаючи гостя) переглядати список фотографій (галерею).
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Дозволяє будь-якому користувачу (включаючи гостя) переглядати одне фото.
     */
    public function view(?User $user, AtelierPhoto $atelierPhoto): bool
    {
        return true;
    }

    /**
     * Дозволяє лише адміністраторам створювати, оновлювати чи видаляти.
     */
    public function create(User $user): bool
    {
        return (bool) $user->is_admin;
    }

    public function update(User $user, AtelierPhoto $atelierPhoto): bool
    {
        return (bool) $user->is_admin;
    }

    public function delete(User $user, AtelierPhoto $atelierPhoto): bool
    {
        return (bool) $user->is_admin;
    }

    // Інші методи (restore, forceDelete) також повинні перевіряти is_admin, якщо використовуються
    public function restore(User $user, AtelierPhoto $atelierPhoto): bool
    {
        return (bool) $user->is_admin;
    }

    public function forceDelete(User $user, AtelierPhoto $atelierPhoto): bool
    {
        return (bool) $user->is_admin;
    }
}