<?php

namespace Reviews;

use DateTime;

interface ReviewsInterface
{
    public function getId(): ?int;
    public function getUserId(): ?int;
    public function getGameId(): ?int;
    public function getRating(): int;
     public function getComment(): ?string;
     public function getReviewDate(): \DateTime;
}
