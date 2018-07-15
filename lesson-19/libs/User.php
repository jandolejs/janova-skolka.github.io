<?php

    namespace Lesson19;

    require_once __DIR__ . '/Validate.php';

    class User
    {
        private $name;
        private $phone;
        private $email;

        function __construct($name, $phone, $email)
        {

            Validate::required($name, 'Jméno') && Validate::name($name, 'Jméno');
            Validate::required($phone, 'Telefon') && Validate::phone($phone, 'Telefon');
            $this->isFilled($email) && Validate::email($email, 'Email');

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

        function isFilled($value)
        {
            return $value !== '';
        }

        function hasEmail()
        {
            return $this->isFilled($this->email);
        }

    }