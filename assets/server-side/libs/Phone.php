<?php

namespace ServerSide;

/**
 * Class Phone
 * @package ServerSide
 */
class Phone extends ContentType
{
    /**
     * @param string $content
     * @throws ValidatorException
     */
    protected function validate(string $content): void
    {
        Validate::required($content, 'Telefon') && Validate::phone($content, 'Telefon');
    }
}
