<?php

namespace Lesson23;

use Tracy\Debugger;

class Validate
{
    static function email($value)
    {
        $isValid = filter_var($value, FILTER_VALIDATE_EMAIL);
        if (!$isValid) {
            Debugger::log("Email not valid: " . $value);
            throw new \Exception('Zadali jste neplatný e-mail, prosím zkontrolujte zadání a opravte jej.');
        }
        return $isValid;
    }


    static function name($value)
    {
        $isValid = !preg_match('/\d/', $value);
        if (!$isValid) {
            Debugger::log("Name not valid: " . $value);
            throw new \Exception('Ve jménu nesmí být číslice, prosím upravte jej.');
        }
        return $isValid;
    }


    static function phone($value)
    {
        $isValid = preg_match('/^ *(\d *){9}$/', $value);
        if (!$isValid) {
            Debugger::log("Phone not valid: " . $value);
            throw new \Exception('Telefon by musí obsahovat právě 9 číslic, prosím opravte jej');
        }
        return $isValid;
    }


    static function required($value)
    {
        $isValid = ($value !== '');
        if (!$isValid) {
            Debugger::log("Some value is missing ");
            throw new \Exception('Nejsou vyplněna všechna povinná pole, prosím vyplňte je');
        }
        return $isValid;
    }
}
