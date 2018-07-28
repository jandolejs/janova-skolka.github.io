<?php

    namespace Lesson21;

    class User
    {
        private $name;
        private $phone;
        private $email;
        private $message;

        function __construct(Name $name, ?Phone $phone, ?Email $email, Message $message)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->email = $email;
            $this->message = $message;
        }

        function getName()
        {
            return $this->name;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function getEmail()
        {
            return $this->email;
        }

        function getMessage()
        {
            return $this->message;
        }

        function hasEmail()
        {
            return $this->email instanceof Email;
        }

        function hasPhone()
        {
            return $this->phone instanceof Phone;
        }

    }
