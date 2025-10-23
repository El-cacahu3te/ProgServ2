<?php

namespace User;

use DateTime;

interface UserInterface {
    public function getId(): ?int;
    public function getUsername(): string;
    public function getPassword(): string;
    public function getEmail(): string;
    public function getBirthDate(): \DateTime;
    public function getBiography(): ?string;
    public function getGender(): ?string;
    public function getSocials(): ?array;
};
