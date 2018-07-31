<?php

namespace Lesson22;

class Message extends ContentType
{
    function validate($content)
    {
        Validate::required($content);
    }
}
