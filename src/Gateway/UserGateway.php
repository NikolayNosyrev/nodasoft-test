<?php

namespace App\Gateway;

use App\DTO\User;

class UserGateway
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findNoYoungerThan(int $ageFrom)
    {
        $stmt = $this->pdo->prepare("SELECT id, first_name, last_name, age, address, settings FROM user WHERE age >= :age_from LIMIT 10");
        $stmt->bindParam(':age_from', $ageFrom, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByNames(array $names)
    {
        $names = array_values($names);

        $in = [];
        foreach ($names as $key => $name) {
            $in[] = ':name_' . $key;
        }
        $inQuery = implode(',', $in);

        $query = sprintf("SELECT DISTINCT id, first_name, last_name, age, address, settings FROM user WHERE first_name IN (%s) OR last_name IN (%s)", $inQuery, $inQuery);

        $stmt = $this->pdo->prepare($query);

        foreach ($names as $key => $name) {
            $stmt->bindValue(':name_' . $key, $name);
        }

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function save(User $user): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO user (first_name, last_name, age, address, settings) VALUES (:first_name, :last_name, :age, :address, :settings)");
        $stmt->execute([
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':age' => $user->getAge(),
            ':address' => $user->getAddress(),
            ':settings' => json_encode($user->getSettings())
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function saveMultiple(array $users): array
    {
        $this->pdo->beginTransaction();

        try {
            $ids = [];
            foreach ($users as $user) {
                $ids[] = $this->save($user);
            }

            $this->pdo->commit();

            return $ids;

        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
