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


    public function __construct(Username $username, Password $password, Name $name, ?Phone $phone, ?Email $email)
    {
        $this->username = $username;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getPhone()
    {
        return $this->phone;
    }


    public function hasPhone()
    {
        return $this->phone instanceof Phone;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function hasEmail()
    {
        return $this->email instanceof Email;
    }
}
