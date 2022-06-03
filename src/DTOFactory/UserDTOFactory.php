<?php

namespace App\DTOFactory;

use App\DTO\User;

class UserDTOFactory
{
    public function create(array $userData): User
    {
        return new User(
            !empty($userData['id']) ? $userData['id'] : null,
            $userData['first_name'],
            $userData['last_name'],
            $userData['age'],
            !empty($userData['settings']) ? $userData['settings'] : []
        );
    }

    public function createArray(array $usersData): array
    {
        $users = [];
        foreach ($usersData as $userData) {
            $users[] = $this->create($userData);
        }
        return $users;
    }

    public function createWithIdBasedOnOld(int $id, User $user)
    {
        return new User(
            $id,
            $user->getFirstName(),
            $user->getLastName(),
            $user->getAge(),
            $user->getSettings()
        );
    }
}
