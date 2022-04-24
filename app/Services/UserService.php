<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Delete the model from the database.
     *
     * @param User $user
     * @return bool|null
     * @throws \LogicException
     */
    public function GDPRdelete(User $user)
    {
        $user->update([
            'name' => "--deleted-user--",
            'username' => "--deleted-user--",
            'email' => "--deleted-user--",
            'password' => '--deleted-user--',
        ]);

        return $user->delete();
    }
}
