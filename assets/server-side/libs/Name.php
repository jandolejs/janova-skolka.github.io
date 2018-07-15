<?php

namespace ServerSide;

/**
 * Class Name
 * @package ServerSide
 */
class Name extends ContentType
{
    /**
     * @param string $content
     * @throws ValidatorException
     */
    protected function validate(string $content): void
    {
        Validate::required($content, 'Jméno') && Validate::name($content, 'Name');
    }
}
