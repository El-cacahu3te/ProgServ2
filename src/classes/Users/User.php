<?php

namespace Users;

use DateTime;

class User implements UserInterface
{

    private ?int $id;
    private string $username;
    private string $password;
    private string $email;
    private string $role;
    private \DateTime $birthdate;
    private ?string $biography;
    private \DateTime $createdAt;


    public function __construct(?int $id, string $username, string $password, string $email, string $role, \DateTime $birthdate, ?string $biography)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->email = $email;
        $this->role = $role;
        $this->birthdate = $birthdate;
        $this->biography = $biography;
        $this->createdAt = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    }

    //GETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->birthdate;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    //SETTERS

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setBirthDate(\DateTime $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    public function setBiography(string $biography): void
    {
        $this->biography = $biography;
    }

    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('Europe/Paris'));;
    }
};
