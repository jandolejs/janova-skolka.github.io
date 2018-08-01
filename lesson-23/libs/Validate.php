<?php

namespace Lesson23;

class Validate
{
    static function email($value)
    {
        $isValid = filter_var($value, FILTER_VALIDATE_EMAIL);
        if (!$isValid) {
            throw new \Exception('Zadali jste neplatný e-mail, prosím zkontrolujte zadání a opravte jej.');
        }
        return $isValid;
    }


    static function name($value)
    {
        $isValid = !preg_match('/\d/', $value);
        if (!$isValid) {
            throw new \Exception('Ve jménu nesmí být číslice, prosím upravte jej.');
        }
        return $isValid;
    }


    static function phone($value)
    {
        $isValid = preg_match('/^ *(\d *){9}$/', $value);
        if (!$isValid) {
            throw new \Exception('Telefon by musí obsahovat právě 9 číslic, prosím opravte jej');
        }
        return $isValid;
    }


    static function required($value)
    {
        $isValid = ($value !== '');
        if (!$isValid) {
            throw new \Exception('Nejsou vyplněna všechna povinná pole, prosím vyplňte je');
        }
        return $isValid;
    }
}
