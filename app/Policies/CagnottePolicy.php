<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cagnotte;

class CagnottePolicy
{
    public function update(User $user, Cagnotte $cagnotte): bool
    {
        return $user->id === $cagnotte->organisateur_id;
    }

    public function delete(User $user, Cagnotte $cagnotte): bool
    {
        return $user->id === $cagnotte->organisateur_id
            || $user->isAdmin();
    }
}
