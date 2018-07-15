<?php

namespace ServerSide;

/**
 * Class Message
 * @package ServerSide
 */
class Message extends ContentType
{
    /**
     * @param string $content
     * @throws ValidatorException
     */
    protected function validate(string $content): void
    {
        Validate::required($content, 'Zpráva');
        if(\strlen($content) < 10) {
            throw new ValidatorException('Zpráva musí být alespoň 10 znaků dlouhá');
        }
    }
}
