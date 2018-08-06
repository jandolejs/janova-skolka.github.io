<?php

namespace Lesson23;

class ContentType
{
    protected $content;


    public function __construct($content)
    {
        $this->validate($content);
        $this->content = $content;
    }


    public function validate($content)
    {
    }


    public function getContent()
    {
        return $this->content;
    }


    public function __toString()
    {
        return $this->getContent();
    }
}
