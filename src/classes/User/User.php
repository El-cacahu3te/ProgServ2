<?php

namespace User;

use DateTime;

class User implements UserInterface {

    private ?int $id;
    private string $username;
    private string $password;
    private string $email;
    private \DateTime $birthdate;
    private ?string $biography;
    private ?string $gender;
    private ?array $socials = [
        'steam' => 'url',
        'twitch' => 'url',
        'instagram' => 'url',
        'facebook' => 'url',
        'tiktok' => 'url',
    ];

    public function __construct(?int $id, string $username, ?string $password, string $email, \DateTime $birthdate, ?string $biography, ?string $gender, ?array $socials)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->biography = $biography;
        $this->gender = $gender;
        $this->socials = $socials;
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
        return $this-biography;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getSocials(): ?array
    {
        return $this->socials;
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

    public function setEmail(string $email): string
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

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function setSocials(array $socials): void
    {
        $this->socials = $socials;
    }
};