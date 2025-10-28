<?php

namespace Reviews;

use DateTime;

class Review implements ReviewsInterface
{
    private ?int $id;
    private ?int $userId;
    private ?int $gameId;
    private int $rating;
    private ?string $comment;
    private \DateTime $reviewDate;

    public function __construct(?int $id, ?int $userId, ?int $gameId, int $rating, ?string $comment, \DateTime $reviewDate)
    {
        $this->userId = $userId;
        $this->gameId = $gameId;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->reviewDate = $reviewDate;
    }

    // GETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getGameId(): ?int
    {
        return $this->gameId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getReviewDate(): \DateTime
    {
        return $this->reviewDate;
    }

    // SETTERS

    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    public function setGameId(?int $gameId): void
    {
        $this->gameId = $gameId;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function setReviewDate(\DateTime $reviewDate): void
    {
        $this->reviewDate = $reviewDate;
    }
}
