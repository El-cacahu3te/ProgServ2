<?php

namespace Users;

use DateTime;

class User implements UserInterface
{

    private ?int $id;
    private string $username;
    private string $password;
    private string $email;
    private \DateTime $birthdate;
    private ?string $biography;
    private \DateTime $created_at;
    private bool $is_admin;



    public function __construct(?int $id, string $username, ?string $password, string $email, \DateTime $birthdate, ?string $biography)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->biography = $biography;
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


    public function getBirthDate(): \DateTime
    {
        return $this->birthdate;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function getCreated_at(): \DateTime
    {
        return $this->created_at;
    }

    public function getIsAdmin(): bool
    {
        return $this->is_admin;
    }


    //SETTERS

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setBirthDate(\DateTime $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    public function setBiography(string $biography): void
    {
        $this->biography = $biography;
    }
    
    public function setIsAdmin(bool $is_admin): void
    {
        $this->is_admin = $is_admin;
    }
};
