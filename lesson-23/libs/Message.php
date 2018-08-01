<?php

namespace Lesson23;

class Message extends ContentType
{
    function validate($content)
    {
        Validate::required($content);
    }
}
