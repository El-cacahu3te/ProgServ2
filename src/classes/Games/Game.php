<?php

namespace Games;

use DateTime;

class Game implements GamesInterface
{
    /*
    const TYPES = [
        'adventure' => 'Aventure',
        'shooter' => 'Jeu de tir',
        'puzzle' => 'Puzzle Game',
        'race' => 'Jeu de course',
        'family' => 'Familial',
        'multiplayer' => 'Multijoueur',
        'online' => 'Online'
        // A remplir
    ];


    const PLATFORMS = [
        'switch' => 'Switch',
        'switch2' => 'Switch 2',
        'playstation5' => 'PS5',
        'xboxseries' => 'Xbox Series',
        'pc' => 'PC'
        // A remplir
    ];
*/
    private ?int $id;
    private string $name;
    // private ?string $imageSlug;
    private \DateTime $releaseDate;
    private ?int $minAge;
    private ?bool $hasSinglePlayer;
    private ?bool $hasMultiPlayer;
    private ?bool $hasCoop;
    private ?bool $hasPvp;

    public function __construct(?int $id, string $name, \DateTime $releaseDate, ?int $minAge, ?bool $hasSinglePlayer, ?bool $hasMultiPlayer, ?bool $hasCoop, ?bool $hasPvp)
    {
        $this->id = $id;
        $this->name = $name;
        $this->releaseDate = $releaseDate;
        $this->minAge = $minAge;
        $this->hasSinglePlayer = $hasSinglePlayer;
        $this->hasMultiPlayer = $hasMultiPlayer;
        $this->hasCoop = $hasCoop;
        $this->hasPvp = $hasPvp;
    }

    // GETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    /*
    public function getImageSlug(): ?string
    {
        return $this->imageSlug;
    }
*/

    public function getReleaseDate(): DateTime
    {
        return $this->releaseDate;
    }

    public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    public function getHasSinglePlayer(): ?bool
    {
        return $this->hasSinglePlayer;
    }


    public function getHasMultiPlayer(): ?bool
    {
        return $this->hasMultiPlayer;
    }


    public function getHasCoop(): ?bool
    {
        return $this->hasCoop;
    }


    public function getHasPvp(): ?bool
    {
        return $this->hasPvp;
    }

    // SETTERS

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setMinAge(?int $minAge): void
    {
        $this->minAge = $minAge;
    }

    public function setHasSinglePlayer(?bool $hasSinglePlayer): void
    {
        $this->hasSinglePlayer = $hasSinglePlayer;
    }


    public function setHasMultiPlayer(?bool $hasMultiPlayer): void
    {
        $this->hasMultiPlayer = $hasMultiPlayer;
    }


    public function setHasCoop(?bool $hasCoop): void
    {
        $this->hasCoop = $hasCoop;
    }


    public function setHasPvp(?bool $hasPvp): void
    {
        $this->hasPvp = $hasPvp;
    }

    /*
    public function setImageSlug(?string $imageSlug): void
    {
        $this->imageSlug = $imageSlug;
    }
*/
};
