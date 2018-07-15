<?php

    namespace Lesson20;

    require_once __DIR__ . '/Validate.php';

    class User
    {
        private $name;
        private $phone;
        private $email;

        function __construct(Name $name, Phone $phone, ?Email $email)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->email = $email;
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

        function hasEmail()
        {
            return $this->email instanceof Email;
        }

    }
