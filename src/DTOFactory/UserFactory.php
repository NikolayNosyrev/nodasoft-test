<?php

namespace App\DTOFactory;

use App\DTO\User;

class UserFactory
{
    public function create(array $userData): User
    {
        return new User(
            !empty($userData['id']) ? $userData['id'] : null,
            $userData['first_name'],
            $userData['last_name'],
            $userData['age'],
            $userData['address'],
            !empty($userData['settings']) ? json_decode($userData['settings'], true) : []
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
            $user->getAddress(),
            $user->getSettings()
        );
    }
}
