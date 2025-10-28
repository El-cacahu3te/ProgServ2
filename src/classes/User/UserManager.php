<?php

namespace User;
use Database;

class UserManager implements UserManagerInterface
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

};