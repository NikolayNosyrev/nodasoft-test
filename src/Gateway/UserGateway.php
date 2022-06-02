<?php

namespace App\Gateway;

use App\DTO\UserDTO;

class UserGateway
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findNoYoungerThanOrFail(int $ageFrom)
    {

    }

    public function findOneByName(string $name)
    {

    }

    public function create(UserDTO $user)
    {

    }
}
