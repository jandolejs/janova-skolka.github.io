<?php

namespace ServerSide;

/**
 * Class Validate
 * @package ServerSide
 */
class Validate
{
    /**
     * @param $value
     * @param $title
     * @return mixed
     * @throws ValidatorException
     */
    public static function email($value, $title)
    {
        $isValid = filter_var($value, FILTER_VALIDATE_EMAIL);
        if (!$isValid) {
            throw new ValidatorException("Pole $title musí být ve tvaru e-mailové adresy");
        }
        return $isValid;
    }


    /**
     * @param $value
     * @param $title
     * @return bool
     * @throws ValidatorException
     */
    public static function name($value, $title)
    {
        $isValid = !preg_match('/\d/', $value);
        if (!$isValid) {
            throw new ValidatorException("Pole $title nesmí obsahovat číslo.");
        }
        return $isValid;
    }


    /**
     * @param $value
     * @param $title
     * @return false|int
     * @throws ValidatorException
     */
    public static function phone($value, $title)
    {
        $isValid = preg_match('/^ *(\d *){9}$/', $value);
        if (!$isValid) {
            throw new ValidatorException("Pole $title musí obsahovat pouze 9 číslic (mezery jsou povoleny).");
        }
        return $isValid;
    }


    /**
     * @param $value
     * @param $title
     * @return bool
     * @throws ValidatorException
     */
    public static function required($value, $title)
    {
        $isValid = ($value !== '');
        if (!$isValid) {
            throw new ValidatorException("Pole $title není vyplněno, prosím, vyplňte jej.");
        }
        return $isValid;
    }
}
