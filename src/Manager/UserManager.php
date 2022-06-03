<?php

namespace App\Manager;

use App\DTOFactory\UserDTOFactory;
use App\Gateway\UserGateway;

class UserManager
{
    private $userGateway;

    private $userDTOFactory;

    public function __construct(UserGateway $userGateway, UserDTOFactory $userDTOFactory)
    {
        $this->userGateway = $userGateway;
        $this->userDTOFactory = $userDTOFactory;
    }

    public function findNoYoungerThan(int $ageFrom): array
    {
        $usersData = $this->userGateway->findNoYoungerThan($ageFrom);

        $users = $this->userDTOFactory->createArray($usersData);

        return $users;
    }

    public function findByNames(array $names): array
    {
        $usersData = $this->userGateway->findByNames($names);

        $users = $this->userDTOFactory->createArray($usersData);

        return $users;
    }

    public function saveMultiple(array $users): array
    {
        $ids = $this->userGateway->saveMultiple($users);

        $newUsers = [];
        foreach ($ids as $key => $id) {
            $newUsers[] = $this->userDTOFactory->createWithIdBasedOnOld($id, $users[$key]);
        }

        return $newUsers;
    }
}
