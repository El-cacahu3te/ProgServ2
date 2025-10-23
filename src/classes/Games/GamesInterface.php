<?php

namespace Games;

use DateTime;

interface GamesInterface {
    public function getId(): ?int;
    public function getName(): string;
    public function getTypes(): array;
    public function getPlatforms(): array;
    public function getReleaseDate(): \DateTime;
    public function getRatings(): array;
    public function getAverageRating(): ?float;
    public function getPrice(): float;
}

