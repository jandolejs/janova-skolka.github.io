<?php

namespace Lesson19;

class Validate
    {
        static function email($value, $title)
        {
            $isValid = filter_var($value, FILTER_VALIDATE_EMAIL);
            if (!$isValid) {
                throw new \Exception("$title byl vyplněn ale je neplatný.");
            }
            return $isValid;
        }

        static function name($value, $title)
        {
            $isValid = !preg_match('/\d/', $value);
            if (!$isValid) {
                throw new \Exception("Pole $title nesmí obsahovat číslo.");
            }
            return $isValid;
        }

        static function phone($value, $title)
        {
            $isValid = preg_match('/^ *(\d *){9}$/', $value);
            if (!$isValid) {
                throw new \Exception("Pole $title musí obsahovat pouze 9 číslic (mezery jsou povoleny).");
            }
            return $isValid;
        }

        static function required($value, $title)
        {
            $isValid = ($value !== '');
            if (!$isValid) {
                throw new \Exception("Pole $title není vyplněno, prosím, vyplňte jej.");
            }
            return $isValid;
        }
    }
