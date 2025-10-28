<?php

namespace Games;

interface GamesManagerInterface {
    public function getGames(): array;
    public function addGame(Game $game): int;
    public function removeGame(int $id): bool;
};