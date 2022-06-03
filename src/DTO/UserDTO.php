<?php

namespace App\DTO;

class UserDTO
{
    private $id;

    private $firstName;

    private $lastName;

    private $age;

    private $settings;

    public function __construct(?int $id, string $firstName, string $lastName, int $age, array $settings = [])
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->settings = $settings;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }
}
