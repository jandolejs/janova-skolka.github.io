<?php

namespace App;

use App\Content\Email;
use App\Content\Name;
use App\Content\Password;
use App\Content\Phone;
use App\Content\Username;

class User
{

    private $username;
    private $name;
    private $phone;
    private $email;
    private $password;


    public function __construct(Username $username, Password $password, Name $name)
    {
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function getName()
    {
        return $this->name;
    }


    public function setPhone($value)
    {
        $this->phone = $value;
    }

    public function hasPhone()
    {
        return $this->phone !== null;
    }


    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function hasEmail()
    {
        return $this->email !== null;
    }
}
