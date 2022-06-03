<?php

namespace App\DTOFactory;

use App\DTO\UserDTO;

class UserDTOFactory
{
    public function create(array $userData): UserDTO
    {
        return new UserDTO(
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

    public function createWithIdBasedOnOld(int $id, UserDTO $user)
    {
        return new UserDTO(
            $id,
            $user->getFirstName(),
            $user->getLastName(),
            $user->getAge(),
            $user->getSettings()
        );
    }
}
