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


}
