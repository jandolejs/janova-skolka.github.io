<?php

namespace ServerSide;

/**
 * Class Email
 * @package ServerSide
 */
class Email extends ContentType
{
    /**
     * @param string $content
     * @throws ValidatorException
     */
    protected function validate(string $content): void
    {
        Validate::required($content, 'Email') && Validate::email($content, 'Email');
    }
}
