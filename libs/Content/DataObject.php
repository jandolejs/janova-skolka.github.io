<?php

namespace App\Content;

abstract class DataObject
{
    protected $content;


    public function __construct($content)
    {
        $this->validate($content);
        $this->content = $content;
    }


    protected function validate($content)
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
