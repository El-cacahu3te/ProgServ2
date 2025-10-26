<?php

namespace Games;

use DateTime;

interface GamesInterface
{
    public function getId(): ?int;
    public function getName(): string;
    //  public function getImageSlug(): ?string;
    public function getReleaseDate(): \DateTime;
    public function getHasSinglePlayer(): ?bool;
    public function getHasMultiPlayer(): ?bool;
    public function getHasCoop(): ?bool;
    public function getHasPvp(): ?bool;
}
