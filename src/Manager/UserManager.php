<?php

namespace App\Manager;

use App\DTOFactory\UserFactory;
use App\Gateway\UserGateway;

class UserManager
{
    private $userGateway;

    private $userFactory;

    const LIMIT = 10;

    public function __construct(UserGateway $userGateway, UserFactory $userFactory)
    {
        $this->userGateway = $userGateway;
        $this->userFactory = $userFactory;
    }

    public function findNoYoungerThan(int $ageFrom): array
    {
        $usersData = $this->userGateway->findNoYoungerThan($ageFrom, self::LIMIT);

        $users = $this->userFactory->createArray($usersData);

        return $users;
    }

    public function findByNames(array $names): array
    {
        $usersData = $this->userGateway->findByNames($names, self::LIMIT);

        $users = $this->userFactory->createArray($usersData);

        return $users;
    }

    public function saveMultiple(array $users): array
    {
        $users = array_values($users);

        $ids = $this->userGateway->saveMultiple($users);

        $newUsers = [];
        foreach ($ids as $key => $id) {
            $newUsers[] = $this->userFactory->createWithIdBasedOnOld($id, $users[$key]);
        }

        return $newUsers;
    }
}
