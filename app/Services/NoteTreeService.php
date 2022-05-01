<?php

namespace App\Services;

use App\Models\User;

class NoteTreeService
{

    /**
     * Get self and all descendant user from the hierarchy.
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDescendantsAndSelfUsers(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return $user->descendantsAndSelf()->orderBy('id')->get();
    }

    /**
     * Builder query for find user from hierarchy by username.
     *
     * @param User $user
     * @param string $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function querySelectedUserFromUserHierarchy(User $user, string $username)
    {
        $users = $this->getDescendantsAndSelfUsers($user);

        $query = User::query()
            ->whereIn('id', $users->pluck('id'))
            ->where('username', $username);

        return $query;
    }

    /**
     * Query for find Selected user notes in user hierarchy.
     *
     * @param User $user
     * @param User $selectedUser
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function queryNotesFromUserHierarchy(User $user, User $selectedUser)
    {
        $notesQuery = $selectedUser?->notes()->with('user')
            ->when($user->id !== $selectedUser->id, function ($query) {
                $query->public();
            });

        return $notesQuery;
    }
}
