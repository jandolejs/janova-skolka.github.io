<?php

namespace Lesson22;

class Email extends ContentType
{
    function validate($content)
    {
        Validate::email($content);
    }
}
