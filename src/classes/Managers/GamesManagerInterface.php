<?php

namespace Managers;
use Games\Game;

interface GamesManagerInterface {
    public function getGames(): array;
    public function getGamesWithStudio(): array;
    public function addGame(Game $game): ?int;
    public function removeGame(int $id): bool;
    
};