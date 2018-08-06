<?php

namespace App;

use App\Content\Message;
use App\Content\Name;
use App\Content\Phone;
use App\Content\Email;

class User
{
    private $name;
    private $phone;
    private $email;
    private $message;


    public function __construct(Name $name, ?Phone $phone, ?Email $email, Message $message)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->message = $message;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getPhone()
    {
        return $this->phone;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function getMessage()
    {
        return $this->message;
    }


    public function hasEmail()
    {
        return $this->email instanceof Email;
    }


    public function hasPhone()
    {
        return $this->phone instanceof Phone;
    }

}
