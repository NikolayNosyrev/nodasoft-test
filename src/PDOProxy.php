<?php

declare(strict_types=1);

namespace App;

class PDOProxy
{
    private $dsn;

    private $username;

    private $password;

    private $options;

    private $pdo;

    public function __construct(string $dsn, ?string $username = null, ?string $password = null, ?array $options = null)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
    }

    private function getPDO()
    {
        if (empty($this->pdo)) {
            $this->pdo = new \PDO($this->dsn, $this->username, $this->password, $this->options);
        }

        return $this->pdo;
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->getPDO(), $method], $arguments);
    }
}
