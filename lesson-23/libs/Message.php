<?php

namespace Lesson23;

class Message extends ContentType
{
    public function validate($content)
    {
        Validate::required($content);
    }
}
