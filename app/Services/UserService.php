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
            'email' => null,
            'email_verified_at' => null,
            'password' => '--deleted-user--',
            //'remember_token' => null,
        ]);

        return $user->delete();
    }
}
