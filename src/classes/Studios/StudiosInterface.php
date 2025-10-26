<?php

namespace Studios;

use DateTime;

interface StudiosInterface
{
    public function getId(): ?int;
    public function getName(): string;
}
