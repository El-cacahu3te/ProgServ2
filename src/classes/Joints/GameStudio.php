<?php

namespace Joints;

use DateTime;

class GameStudio
{
    private ?int $id;
    private ?int $gameId;
    private ?int $studioId;

    public function __construct(?int $id, ?int $gameId, ?int $studioId)
    {
        $this->id = $id;
        $this->gameId = $gameId;
        $this->studioId = $studioId;
    }

    // GETTERS

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getGameId(): ?int
    {
        return $this->gameId;
    }
    public function getStudioId(): ?int
    {
        return $this->studioId;
    }

    // SETTERS

    public function setGameId(?int $gameId): void
    {
        $this->gameId = $gameId;
    }
    public function setStudioId(?int $studioId): void
    {
        $this->studioId = $studioId;
    }
}
