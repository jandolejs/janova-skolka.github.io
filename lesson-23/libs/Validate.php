<?php

namespace Lesson23;

use Tracy\Debugger;

class Validate
{
    static function email($value)
    {
        $isValid = filter_var($value, FILTER_VALIDATE_EMAIL);
        if (!$isValid) {
            Debugger::log('email_not_valid="' . $value . '"');
            throw new \Exception('Zadali jste neplatný e-mail, prosím zkontrolujte zadání a opravte jej.');
        }
        return $isValid;
    }


    static function name($value)
    {
        $isValid = !preg_match('/\d/', $value);
        if (!$isValid) {
            Debugger::log('name_not_valid="' . $value . '"');
            throw new \Exception('Ve jménu nesmí být číslice, prosím upravte jej.');
        }
        return $isValid;
    }


    static function phone($value)
    {
        $isValid = preg_match('/^ *(\d *){9}$/', $value);
        if (!$isValid) {
            Debugger::log('phone_not_valid="' . $value . '"');
            throw new \Exception('Telefon by musí obsahovat právě 9 číslic, prosím opravte jej');
        }
        return $isValid;
    }


    static function required($value)
    {
        $isValid = ($value !== '');
        if (!$isValid) {
            Debugger::log('some_value_is_missing="null"');
            throw new \Exception('Nejsou vyplněna všechna povinná pole, prosím vyplňte je');
        }
        return $isValid;
    }
}
