<?php

namespace Users;

use DateTime;

interface UserInterface {
    public function getId(): ?int;
    public function getUsername(): string;
    public function getPassword(): string;
    public function getEmail(): string;
    public function getBirthDate(): \DateTime;
    public function getBiography(): ?string;
};
