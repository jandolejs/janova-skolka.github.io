<?php

namespace Lesson23;

class Message extends ContentType
{
    protected function validate($content)
    {
        Validate::required($content);
    }
}
