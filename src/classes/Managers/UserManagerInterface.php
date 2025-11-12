<?php

namespace Managers;

use Users\User;

interface UserManagerInterface
{
    public function getUsers(): array;
    public function addUser(User $user): ?int;
    public function removeUser(int $id): bool;
};
