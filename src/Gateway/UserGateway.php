<?php

declare(strict_types=1);

namespace App\Gateway;

use App\DTO\User;
use App\PDOProxy;

class UserGateway
{
    private $pdoProxy;

    public function __construct(PDOProxy $pdoProxy)
    {
        $this->pdoProxy = $pdoProxy;
    }

    public function findNoYoungerThan(int $ageFrom, int $limit): array
    {
        $stmt = $this->pdoProxy->prepare(
            "SELECT id, first_name, last_name, age, address, settings
            FROM user
            WHERE age >= :age_from
            LIMIT :limit"
        );
        $stmt->bindParam(':age_from', $ageFrom, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByNames(array $names, int $limit): array
    {
        $names = array_values($names);

        $in = [];
        foreach ($names as $key => $name) {
            $in[] = ':name_' . $key;
        }
        $inQuery = implode(',', $in);

        $query = sprintf(
            "SELECT DISTINCT id, first_name, last_name, age, address, settings
            FROM user
            WHERE first_name IN (%s) OR last_name IN (%s)
            LIMIT :limit", $inQuery, $inQuery);

        $stmt = $this->pdoProxy->prepare($query);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);

        foreach ($names as $key => $name) {
            $stmt->bindValue(':name_' . $key, $name);
        }

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function save(User $user): int
    {
        $stmt = $this->pdoProxy->prepare(
            "INSERT INTO user
            (first_name, last_name, age, address, settings)
            VALUES
            (:first_name, :last_name, :age, :address, :settings)"
        );
        $stmt->execute([
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':age' => $user->getAge(),
            ':address' => $user->getAddress(),
            ':settings' => json_encode($user->getSettings())
        ]);

        return (int)$this->pdoProxy->lastInsertId();
    }

    public function saveMultiple(array $users): array
    {
        $this->pdoProxy->beginTransaction();

        try {
            $ids = [];
            foreach ($users as $user) {
                $ids[] = $this->save($user);
            }

            $this->pdoProxy->commit();

            return $ids;

        } catch (\Throwable $e) {
            $this->pdoProxy->rollBack();
            throw $e;
        }
    }
}
