<?php

namespace Platforms;

use DateTime;

interface PlatformsInterface
{
    public function getId(): ?int;
    public function getName(): string;
}
