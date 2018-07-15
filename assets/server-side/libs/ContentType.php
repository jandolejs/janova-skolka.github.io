<?php

namespace ServerSide;

/**
 * Class ContentType
 * @package ServerSide
 */
class ContentType
{
    /**
     * @var string
     */
    protected $content;


    /**
     * ContentType constructor.
     * @param string $content
     * @throws ValidatorException
     */
    public function __construct(string $content)
    {
        $this->validate($content);
        $this->content = $content;
    }


    /**
     * @param string $content
     * @throws ValidatorException
     */
    protected function validate(string $content): void
    {
    }


    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getContent();
    }
}
