<?php

namespace ServerSide;

/**
 * Class Name
 * @package ServerSide
 */
class Username extends ContentType
{
    /**
     * @param string $content
     * @throws ValidatorException
     */
    protected function validate(string $content): void
    {
        Validate::required($content, 'Přihlašovací jméno') && Validate::username($content, 'Přihlašovací jméno');
    }
}
