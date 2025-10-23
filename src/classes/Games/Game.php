<?php

namespace Games;

use DateTime;

class Game implements GamesInterface
{
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

    private ?int $id;
    private string $name;
    private array $types = [];
    private array $platforms = [];
    private \DateTime $releaseDate;
    private array $ratings;
    private ?float $averageRating = null;
    private float $price;
    // private array $comments = [];

    public function __construct(?int $id, string $name, array $types, array $platforms, \DateTime $releaseDate, float $price)
    {
        /*
        if (empty($name)) {
            throw new \InvalidArgumentException("Le nom est requis.");
        } else if (strlen($name) < 2) {
            throw new \InvalidArgumentException("Le nom doit contenir au moins 2 caractères.");
        }

        if (empty($types)) {
            throw new \InvalidArgumentException("Le type est requis.");
        }

        if (empty($date)) {
            throw new \InvalidArgumentException("Une date valide est requis.");
        }

        if ($price < 0) {
            throw new \InvalidArgumentException("Le prix doit être un nombre positif.");
        }
            */
        $this->id = $id;
        $this->name = $name;
        $this->types = $types;
        $this->platforms = $platforms;
        $this->releaseDate = $releaseDate;
        $this->price = $price;
    }

    // GETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->id;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function getPlatforms(): array
    {
        return $this->platforms;
    }

    public function getReleaseDate(): \DateTime
    {
        return $this->releaseDate;
    }

    public function getRatings(): array
    {
        return $this->ratings;
    }

    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

        public function getPrice(): float
    {
        return $this->price;
    }

    // SETTERS

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPlatforms(array $platforms): void
    {
        $this->platforms = $platforms;
    }

    public function setTypes(array $types): void
    {
        $this->types = $types;
    }

    public function setReleaseDate(\DateTime $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setAverageRating(): void
    {
        $ratings = $this->getRatings();

        if (empty($ratings)) {
            $this->averageRating = null;
        } else {
            $this->averageRating = array_sum($ratings) / count($ratings);
        }
    }

    // AUTRES
    public function addRatings(int $rating): void
    {
        $this->ratings[] = $rating;
    }
};
