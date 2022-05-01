<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

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


    /**
     * Create a new invitable pending user in the system.
     *
     * @param int $parentId // user who creates the invitation
     * @return User
     */
    public function createPendingUser(int $parentId): \App\Models\User
    {
        $invCode = $parentId . Str::random(32);

        $user = User::create([
            'name' => "--pending-user--",
            'username' => "--pending-user--",
            'email' => "--pending-user--",
            'password' => '--pending-user--',
            'invitation_code' => $invCode,
            'parent_id' => auth()->id(),
        ]);

        return $user;
    }
}
